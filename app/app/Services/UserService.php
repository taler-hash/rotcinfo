<?php

namespace App\Services;

use App\Models\User;

class UserService {
    public function getUsers($request) {
        $model = new User();
        return User::with('roles')
        ->whereHas('roles', function ($q) {
            $q->where('name', 's1-admin');
        })
        ->whereAny($model->getFillable(), 'LIKE', "%{$request->searchString}%")
        ->orderBy($request->sortBy, $request->sortType)
        ->paginate($request->rows);
    }

    public function showUser($request) {
        return User::find($request->id);
    }

    public function storeUser($request) {
        $user = User::create($request->all());
        $user->assignRole('s1-admin');
    }

    public function updateUser($request) {
        User::find($request->id)->update(!empty($request->password) ? $request->all() : $request->except(['password']));
    }

    public function deleteUser($request) {
        User::find($request->id)->delete();
    }

    public function userCount() {
        return User::with('roles')
        ->whereHas('roles', function ($q) {
            $q->whereNotIn('name', ['admin']);
        })
        ->count();
    }
}