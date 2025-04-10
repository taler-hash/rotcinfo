<?php

namespace App\Services;
use App\Models\Announcement;
use App\Models\Cadet;
use App\Services\Base64;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AnnouncementService {

    public function getAnnouncements($request) {
        $model = new Announcement();
        $announcements = Announcement::with('media')
        ->whereAny($model->getFillable(), 'LIKE', "%{$request->searchString}%")
        ->orderBy($request->sortBy, $request->sortType)
        ->paginate($request->rows);

        return $announcements;
    }

    public function showAnnouncement($request) {
        return Announcement::with(['media'])->find($request->id);
    }

    public function storeAnnouncement($request) {
        $announcement = Announcement::create($request->except(['image']));

        $announcement->addMedia(Base64::convertToUploadedFile($request->image, $request->header))->toMediaCollection('announcements');
    }

    public function updateAnnouncement($request) {
        
        $announcement = Announcement::find($request->id);
        $announcement->update($request->except(['image', 'media', 'created_at', 'updated_at']));

        if(!empty($request->image)) {
            $announcement->clearMediaCollection('announcements');
            $announcement->addMedia(Base64::convertToUploadedFile($request->image, $request->name))->toMediaCollection('announcements');
        }
    }

    public function deleteAnnouncement($request) {
        $announcement = Announcement::find($request->id);

        $announcement->clearMediaCollection('announcements');
        $announcement->delete();
    }

    public function getAnnouncementCount() {
        return Announcement::count();
    }

    public function loginAnnouncement($request) {
        $cadet = Cadet::where('email', $request->email)->first();

        if (!$cadet || (!Hash::check($request->password, $cadet->password)) || $cadet->status === 'registered') {
            throw ValidationException::withMessages([
                'email' => 'Invalid email or password',
            ]);
        }
    }
    
}