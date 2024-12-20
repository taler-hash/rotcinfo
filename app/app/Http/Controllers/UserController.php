<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\UserService;

class UserController extends Controller
{

    protected $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function display() {
        return Inertia::render('User/User');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json($this->userService->getUsers($request));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $this->userService->storeUser($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return response()->json($this->userService->showUser($request));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request)
    {
        $this->userService->updateUser($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $this->userService->deleteUser($request);
    }

    public function count() {
        return response()->json($this->userService->userCount());
    }
}
