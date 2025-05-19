<?php

namespace App\Services;

use App\Mail\SuccessEnrolledCadetMail;
use App\Models\Cadet;
use App\Models\ClassYear;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\SuccessRegisteredCadetMail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class CadetService {

    public function getCadets($request) {
        $model = new Cadet();
        return Cadet::with(['media', 'classyear'])
        ->when($request?->class_year_id, function($q) use($request) {
            $q->where('class_year_id', $request->class_year_id);
        })
        ->whereAny($model->getFillable(), 'LIKE', "%{$request->searchString}%")
        ->orderBy($request->sortBy, $request->sortType)
        ->paginate($request->rows);
    }

    public function showCadet($request) {
        
        if(!empty($request?->for_info)) {
            $cadet = User::find(auth()->user()->id)->cadet;

            if(!$cadet) {
                return response()->json([], 404);
            }

            return response()->json($cadet);
        }

        return response()->json(Cadet::find($request->id));
    }

    public function storeCadet($request) {
        $fields = $request->all();
        $fields['status'] = 'registered';
        $fields['password'] = Hash::make($request->password);
        $fields['cadet_identifier'] = $request->lastname[0].$request->firstname[0]."-".Str::random(5);
        
        if($request?->route === 'register' && !Cache::get('open')) {
            return response()->json(['closed' => true], 410);
        }
        
        Mail::to($request->email)->send(new SuccessRegisteredCadetMail($request->except('image')));
        $cadet = Cadet::create(collect($fields)->except(['image'])->toArray());
        $cadet->addMedia(Base64::convertToUploadedFile($request->image, $request->name))->toMediaCollection('cadets');

        $cadet->refresh();

        $user = User::create([
            'username' => $cadet->id_number,
            'name' => $cadet->name,
            'position' => 'cadet',
            'password' => $fields['password'],
            'status' => 'inactive'
        ]);

        $user->assignRole('cadet');

        if($request?->route === 'register') {
            return response()->json($cadet);
        }
    }

    public function updateCadet($request) {
        $cadet = Cadet::find($request->id);
        $cadet->status = $request->status;

        if ($cadet->isDirty('status')) {
            if($request->status === 'enrolled') {
                Mail::to($request->email)->send(new SuccessEnrolledCadetMail($request));
                User::firstWhere('username', $cadet->id_number)->update(['status' => 'active']);
            } else {
                User::firstWhere('username', $cadet->id_number)->update(['status' => 'inactive']);
            }
            
        }

        $cadet->update($request->except(['image', 'media', 'created_at', 'updated_at']));

        if (!empty($request->image)) {
            $cadet->clearMediaCollection('cadets');
            $cadet->addMedia(Base64::convertToUploadedFile($request->image, $request->name))->toMediaCollection('cadets');
        }
    }
    

    public function deleteCadet($request) {
        Cadet::find($request->id)->delete();
    }

    public function cadetCount() {
        return Cadet::count();
    }

    public function createCadet() {
        if(Cache::get('open')) {
            return Inertia::render('Cadet/CadetRegister', ['class_year_id' => Cache::get('open')]);
        }

        return Inertia::render('Cadet/CadetNotOpen');
    }

    public function openRegistration($request) {
        Cache::remember('open', 24 * 60 * 60, function() use ($request) {
            return $request->class_year_id;
        });
    }

    public function closeRegistration() {
        Cache::forget('open');
    }
    
    public function getCl() {
        return DB::table('cadets')
        ->select('cl')
        ->distinct()
        ->get()
        ->map(function($item) { return $item->cl; })->toArray();
    }

    public function generateReport($request) {
        $attributes = $request->all();
        $cadets = Cadet::where('class_year_id', $request->class_year_id)
        ->active()
        ->get()
        ->sortBy('subject')
        ->groupBy('subject')
        ->map(function($item) {
            return $item->sortByDesc('gender')->groupBy('gender')->map(function($cadet) {
                return $cadet->sortByDesc('name');
            });
        })->toArray();
        $classYear = ClassYear::find($request->class_year_id)->first();
        $sy = ((int)$classYear->year - 1)."-{$classYear->year}";
        $attributes['sy'] = $sy;
        $attributes['cadets'] = $cadets;
        $attributes['date'] = Carbon::parse($attributes['date'])->format('d-M-Y');
        $attributes['setFontSize'] = function ($str) {
            return $this->setFontSize($str);
        };

        $pdf = Pdf::loadView("Reports.pdf", $attributes)->setPaper('a4', 'landscape');

        return $pdf->download("report({$classYear->cl}).pdf");
        return view('Reports/pdf', $attributes);
    }

    public function validateReport($request) {
        $cadets = Cadet::where('class_year_id', $request->class_year_id)
        ->active();

        if($cadets->count() === 0) {
            throw ValidationException::withMessages([
                'cadets' => ['No Cadets found for this class year.'],
            ]);

        }
    }

    public function trackCadet($request) {
        return response()->json(Cadet::with('classyear')->find($request->id));
    }

    public function setFontSize($str) {
        if(strlen($str) >= 20 && strlen($str) <= 49) {
            return 't-small';
        } else if (strlen($str) >= 50 && strlen($str) <= 74) {
            return 't-smaller';
        } else if (strlen($str) >= 75) {
            return 't-xsmall';
        }
    }
}