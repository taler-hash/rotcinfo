<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CadetController;
use App\Http\Controllers\ClassYearController;
use Illuminate\Support\Facades\Cache;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Users
    Route::controller(UserController::class)
    ->prefix('/users')
    ->middleware(['role:admin'])
    ->group(function() {
        Route::get('/', 'display')->name('users.display');
        Route::get('/index', 'index')->name('users.index');
        Route::post('/store', 'store')->name('users.store');
        Route::get('/show', 'show')->name('users.show');
        Route::get('/edit', 'edit')->name('users.edit');
        Route::put('/update', 'update')->name('users.update');
        Route::delete('/delete', 'delete')->name('users.delete');
        Route::get('/count', 'count')->name('users.count');
    });

        //Cadets
        Route::controller(CadetController::class)
        ->prefix('/cadets')
        ->middleware(['role:admin|s1-admin'])
        ->group(function() {
            Route::get('/', 'display')->name('cadets.display');
            Route::get('/index', 'index')->name('cadets.index');
            Route::get('/show', 'show')->name('cadets.show');
            Route::get('/edit', 'edit')->name('cadets.edit');
            Route::put('/update', 'update')->name('cadets.update');
            Route::delete('/delete', 'delete')->name('cadets.delete');
            Route::get('/count', 'count')->name('cadets.count');
            Route::post('/open', 'open')->name('cadets.open');
            Route::post('/close', 'close')->name('cadets.close');
            Route::get('/report', 'report')->name('cadets.report');
            Route::post('/report', 'validateReport')->name('cadets.report.validate');
        });

        //ClassYear
        Route::controller(ClassYearController::class)
        ->prefix('/classyears')
        ->middleware(['role:admin|s1-admin'])
        ->name('classYears.')
        ->group(function() {
            Route::get('/', 'display')->name('display');
            Route::get('/index', 'index')->name('index');
            Route::get('/show', 'show')->name('show');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit', 'edit')->name('edit');
            Route::put('/update', 'update')->name('update');
            Route::delete('/delete', 'delete')->name('delete');
            Route::delete('/count', 'count')->name('count');
        });
});

Route::controller(CadetController::class)
->prefix('/cadets')
->name('cadets.')
->group(function() {
    Route::get('/register', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/track', 'track')->name('track');
});

require __DIR__.'/auth.php';
