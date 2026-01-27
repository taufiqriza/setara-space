<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register Model Observers
        \App\Models\Product::observe(\App\Observers\ProductObserver::class);
        \App\Models\Order::observe(\App\Observers\OrderObserver::class);

        // Listen for Login Events
        \Illuminate\Support\Facades\Event::listen(\Illuminate\Auth\Events\Login::class, function ($event) {
            \App\Models\Activity::create([
                'user_id' => $event->user->id,
                'action' => 'user_login',
                'description' => "User {$event->user->name} logged in.",
                'ip_address' => request()->ip(),
            ]);
        });
    }
}
