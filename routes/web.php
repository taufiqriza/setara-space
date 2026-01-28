<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $favorites = App\Models\Product::with('category')
        ->where('is_favorite', true)
        ->where('is_active', true)
        ->take(4)
        ->get();
    
    // Fetch all active products that are NOT favorites
    $others = App\Models\Product::with('category')
        ->where('is_favorite', false)
        ->where('is_active', true)
        ->inRandomOrder()
        ->take(24) 
        ->get();

    return view('frontend.home', compact('favorites', 'others'));
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
    // Dashboard
    Route::get('/dashboard', App\Livewire\Control\Dashboard::class)->name('dashboard');
    
    // Logout
    Route::post('/logout', function () {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('control.login');
    })->name('logout');
    
    // POS (Livewire component)
    Route::get('/pos', App\Livewire\Control\Pos\PosPage::class)->name('pos');
    
    // Activity (Livewire component)
    Route::get('/activity', App\Livewire\Control\Activity\ActivityDashboard::class)->name('activity');

    // Order History (Livewire component)
    Route::get('/orders', App\Livewire\Control\Orders\OrderHistory::class)->name('orders');
    
    // Report
    Route::get('/report', App\Livewire\Control\Report\ReportDashboard::class)->name('report');
    
    // Inventory (Livewire component)
    Route::get('/inventory', App\Livewire\Control\Inventory\ProductManager::class)->name('inventory');
    
    // Teams (Livewire component)
    Route::get('/teams', App\Livewire\Control\Teams\TeamManager::class)->name('teams');

    // Settings
    Route::get('/settings', App\Livewire\Control\Settings\SettingsPage::class)->name('settings');
    

});
