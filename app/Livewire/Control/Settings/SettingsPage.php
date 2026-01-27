<?php

namespace App\Livewire\Control\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class SettingsPage extends Component
{
    public $activeTab = 'general'; // general, security, notifications
    
    // Profile Data
    public $name;
    public $email;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public function mount()
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
        ]);

        $user = auth()->user();
        $user->update([
            'name' => $this->name,
            'email' => $this->email
        ]);

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => 'Profile Updated',
            'text' => 'Your profile details have been saved.'
        ]);
        
        // Log activity
        Activity::create([
            'user_id' => $user->id,
            'action' => 'update_profile',
            'description' => 'User updated their profile details.',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();
        $user->update([
            'password' => Hash::make($this->new_password)
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => 'Password Changed',
            'text' => 'Your password has been securely updated.'
        ]);
        
        Activity::create([
            'user_id' => $user->id,
            'action' => 'update_password',
            'description' => 'User changed their password.',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }

    public function render()
    {
        // 1. Login Activity
        $loginHistory = Activity::where('user_id', auth()->id())
            ->whereIn('action', ['login', 'logout', 'failed_login'])
            ->latest()
            ->take(5)
            ->get();

        // 2. Active Sessions (If using database driver)
        // We'll mock if table doesn't exist or just query valid sessions
        $sessions = [];
        try {
            if (\Schema::hasTable('sessions')) {
                $sessions = DB::table('sessions')
                    ->where('user_id', auth()->id())
                    ->get()
                    ->map(function ($session) {
                        return (object) [
                            'ip_address' => $session->ip_address,
                            'user_agent' => $session->user_agent,
                            'last_activity' => \Carbon\Carbon::createFromTimestamp($session->last_activity),
                            'is_current' => $session->id === session()->getId()
                        ];
                    });
            } else {
                 // Fallback: Show current session
                 $sessions = collect([(object)[
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'last_activity' => now(),
                    'is_current' => true
                 ]]);
            }
        } catch (\Exception $e) {
            // Fallback
             $sessions = collect([(object)[
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'last_activity' => now(),
                'is_current' => true
             ]]);
        }

        return view('livewire.control.settings.settings-page', [
            'loginHistory' => $loginHistory,
            'sessions' => $sessions
        ])->layout('layouts.control', ['title' => 'Settings']);
    }
}
