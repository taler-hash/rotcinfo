<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClassYearRequest;
use App\Http\Requests\UpdateClassYearRequest;
use App\Models\ClassYear;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\ClassYearService;

class ClassYearController extends Controller
{

    protected $classYearService;

    public function __construct()
    {
        $this->classYearService = new ClassYearService();
    }

    public function display() {
        return Inertia::render('ClassYear/ClassYear');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json($this->classYearService->getClassYears($request));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateClassYearRequest $request)
    {
        $this->classYearService->storeClassYear($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return response()->json($this->classYearService->showClassYear($request));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClassYearRequest $request)
    {
        $this->classYearService->updateClassYear($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $this->classYearService->deleteClassYear($request);
    }

    public function count() {
        return response()->json($this->classYearService->classYearCount());
    }
}
