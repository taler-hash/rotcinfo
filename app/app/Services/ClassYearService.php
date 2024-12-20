<?php

namespace App\Services;

use App\Models\ClassYear;

class ClassYearService {
    public function getClassYears($request) {
        $model = new ClassYear();
        return ClassYear::whereAny($model->getFillable(), 'LIKE', "%{$request->searchString}%")
        ->orderBy($request->sortBy, $request->sortType)
        ->paginate($request->rows);
    }

    public function showClassYear($request) {
        return ClassYear::find($request->id);
    }

    public function storeClassYear($request) {
        ClassYear::create($request->all());
    }

    public function updateClassYear($request) {
        ClassYear::find($request->id)->update(!empty($request->password) ? $request->all() : $request->except(['password']));
    }

    public function deleteClassYear($request) {
        ClassYear::find($request->id)->delete();
    }

    public function ClassYearCount() {
        return ClassYear::count();
    }
}