<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCadetRequest;
use App\Http\Requests\GenerateReportRequest;
use App\Http\Requests\OpenRegistrationRequest;
use App\Http\Requests\ShowCadetRequest;
use App\Http\Requests\UpdateCadetRequest;
use App\Services\CadetService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CadetController extends Controller
{

    protected $cadetService;

    public function __construct()
    {
        $this->cadetService = new CadetService();
    }

    public function display() {
        return Inertia::render('Cadet/Cadet');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json($this->cadetService->getCadets($request));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->cadetService->createCadet();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCadetRequest $request)
    {
        return $this->cadetService->storeCadet($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return $this->cadetService->showCadet($request);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCadetRequest $request)
    {
        $this->cadetService->updateCadet($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $this->cadetService->deleteCadet($request);
    }

    public function count() {
        return response()->json($this->cadetService->cadetCount());
    }

    public function open(OpenRegistrationRequest $request) {
        $this->cadetService->openRegistration($request);
    }

    public function close() {
        $this->cadetService->closeRegistration();
    }

    public function cl() {
       return response()->json($this->cadetService->getCl());
    }

    public function report(Request $request) {
        return $this->cadetService->generateReport($request);
    }

    public function track(Request $request) {
        return Inertia::render('Cadet/CadetTrack');
    }
}
