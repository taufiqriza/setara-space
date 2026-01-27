<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('frontend.home');
})->name('home');

/*
|--------------------------------------------------------------------------
| Admin/Control Panel Routes
|--------------------------------------------------------------------------
*/

// Guest routes (not logged in)
Route::middleware('guest')->group(function () {
    Route::get('/control', Login::class)->name('control.login');
});

// Authenticated routes
Route::middleware('auth')->prefix('control')->name('control.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('control.dashboard');
    })->name('dashboard');
    
    // Logout
    Route::post('/logout', function () {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('control.login');
    })->name('logout');
    
    // POS (Livewire component)
    Route::get('/pos', App\Livewire\Control\Pos\PosPage::class)->name('pos');
    
    // Activity (will be Livewire component)
    Route::get('/activity', function () {
        return view('control.activity');
    })->name('activity');
    
    // Report
    Route::get('/report', function () {
        return view('control.report');
    })->name('report');
    
    // Inventory (Livewire component)
    Route::get('/inventory', App\Livewire\Control\Inventory\ProductManager::class)->name('inventory');
    
    // Teams (superadmin only)
    Route::get('/teams', function () {
        return view('control.teams');
    })->name('teams');
    
    // Settings
    Route::get('/settings', function () {
        return view('control.settings');
    })->name('settings');
});
