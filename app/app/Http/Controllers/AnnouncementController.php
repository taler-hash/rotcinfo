<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnouncementLoginRequest;
use App\Http\Requests\CreateAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;
use App\Services\AnnouncementService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AnnouncementController extends Controller
{
    public $announcementService;

    public function __construct()
    {
        $this->announcementService = new AnnouncementService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json($this->announcementService->getAnnouncements($request));
    }
    
    public function display() {
        return Inertia::render('Announcement/Announcement');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAnnouncementRequest $request)
    {
       
        $this->announcementService->storeAnnouncement($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return response()->json($this->announcementService->showAnnouncement($request));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnnouncementRequest $request)
    {
        $this->announcementService->updateAnnouncement($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $this->announcementService->deleteAnnouncement($request);
    }

    public function count() {
        return response()->json($this->announcementService->getAnnouncementCount());
    }

    public function login(AnnouncementLoginRequest $request) {
        return $this->announcementService->loginAnnouncement($request);
    }
}