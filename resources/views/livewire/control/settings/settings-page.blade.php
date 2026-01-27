<div class="min-h-screen flex flex-col">
    {{-- Header --}}
    <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 flex-shrink-0 sticky top-0 z-30">
        <div class="flex items-center gap-4">
            <button onclick="window.toggleSidebar()" class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 hover:bg-gray-100 text-gray-600 transition-colors shadow-sm ring-1 ring-gray-200">
                <i class="fas fa-bars"></i>
            </button>
            <div>
                <h1 class="text-xl font-bold text-gray-900">Settings & Security</h1>
            </div>
        </div>
    </header>

    <div class="flex-1 p-6 max-w-7xl mx-auto w-full">
        
        {{-- Tabs --}}
        <div class="flex items-center gap-2 mb-8 border-b border-gray-200">
            <button wire:click="setTab('general')" 
                    class="px-4 py-3 text-sm font-medium border-b-2 transition-colors duration-200 flex items-center gap-2 {{ $activeTab === 'general' ? 'border-space-600 text-space-700' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                <i class="fas fa-user-circle"></i> General
            </button>
            <button wire:click="setTab('security')" 
                    class="px-4 py-3 text-sm font-medium border-b-2 transition-colors duration-200 flex items-center gap-2 {{ $activeTab === 'security' ? 'border-space-600 text-space-700' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                <i class="fas fa-shield-alt"></i> Security
            </button>
            <button wire:click="setTab('notifications')" 
                    class="px-4 py-3 text-sm font-medium border-b-2 transition-colors duration-200 flex items-center gap-2 {{ $activeTab === 'notifications' ? 'border-space-600 text-space-700' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                <i class="fas fa-bell"></i> Notifications
            </button>
        </div>

        {{-- Content Area --}}
        <div class="space-y-6">
            
            {{-- GENERAL TAB --}}
            @if($activeTab === 'general')
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- Profile Card --}}
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center">
                            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-space-500 to-indigo-600 mx-auto mb-4 flex items-center justify-center text-3xl font-bold text-white shadow-lg ring-4 ring-white">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">{{ auth()->user()->name }}</h2>
                            <p class="text-sm text-gray-500 mb-6">{{ auth()->user()->roles->first()->name ?? 'Staff' }}</p>
                            
                            <div class="flex justify-center gap-2">
                                <button class="px-4 py-2 bg-space-50 text-space-600 hover:bg-space-100 rounded-lg text-sm font-medium transition-colors">
                                    Change Avatar
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Form --}}
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                            <h3 class="text-lg font-bold text-gray-900 mb-6">Profile Details</h3>
                            <form wire:submit.prevent="updateProfile" class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-700">Full Name</label>
                                        <input type="text" wire:model="name" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-space-500 focus:ring-2 focus:ring-space-200 outline-none transition-all">
                                        @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-700">Email Address</label>
                                        <input type="email" wire:model="email" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-space-500 focus:ring-2 focus:ring-space-200 outline-none transition-all">
                                        @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="flex justify-end pt-4">
                                    <button type="submit" class="px-6 py-2.5 bg-space-600 hover:bg-space-700 text-white rounded-xl font-medium shadow-lg shadow-space-500/30 transition-all hover:scale-[1.02]">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            {{-- SECURITY TAB --}}
            @if($activeTab === 'security')
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    {{-- Password Change --}}
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                        <div class="flex items-center gap-3 mb-6">
                             <div class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center text-orange-500">
                                 <i class="fas fa-lock"></i>
                             </div>
                             <h3 class="text-lg font-bold text-gray-900">Change Password</h3>
                        </div>
                        
                        <form wire:submit.prevent="updatePassword" class="space-y-5">
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700">Current Password</label>
                                <input type="password" wire:model="current_password" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-space-500 focus:ring-2 focus:ring-space-200 outline-none transition-all">
                                @error('current_password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-700">New Password</label>
                                    <input type="password" wire:model="new_password" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-space-500 focus:ring-2 focus:ring-space-200 outline-none transition-all">
                                    @error('new_password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-700">Confirm Password</label>
                                    <input type="password" wire:model="new_password_confirmation" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-space-500 focus:ring-2 focus:ring-space-200 outline-none transition-all">
                                </div>
                            </div>
                            <div class="flex justify-end pt-2">
                                <button type="submit" class="px-6 py-2.5 bg-gray-900 hover:bg-black text-white rounded-xl font-medium transition-all hover:scale-[1.02]">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Login History --}}
                    <div class="space-y-6">
                         <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                             <div class="flex items-center gap-3 mb-6">
                                 <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-500">
                                     <i class="fas fa-history"></i>
                                 </div>
                                 <h3 class="text-lg font-bold text-gray-900">Login History</h3>
                             </div>
                             
                             <div class="space-y-4">
                                 @forelse($loginHistory as $activity)
                                     <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 border border-gray-100">
                                         <div class="flex items-center gap-3">
                                             <i class="fas {{ $activity->action == 'login' ? 'fa-sign-in-alt text-green-500' : 'fa-info-circle text-gray-400' }}"></i>
                                             <div>
                                                 <p class="text-sm font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $activity->action)) }}</p>
                                                 <p class="text-xs text-gray-500">{{ $activity->ip_address }} • {{ $activity->created_at->diffForHumans() }}</p>
                                             </div>
                                         </div>
                                         <span class="text-xs font-mono bg-white px-2 py-1 rounded border border-gray-200 text-gray-500">
                                             {{ $activity->created_at->format('H:i') }}
                                         </span>
                                     </div>
                                 @empty
                                     <div class="text-center text-gray-400 text-sm py-4">No login history found</div>
                                 @endforelse
                             </div>
                         </div>
                         
                         {{-- Active Sessions --}}
                         <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                             <div class="flex items-center gap-3 mb-6">
                                 <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center text-green-500">
                                     <i class="fas fa-desktop"></i>
                                 </div>
                                 <div>
                                     <h3 class="text-lg font-bold text-gray-900">Active Sessions</h3>
                                     <p class="text-xs text-gray-500">Devices currently logged in</p>
                                 </div>
                             </div>
                             
                             <div class="space-y-3">
                                 @foreach($sessions as $session)
                                     <div class="flex items-center justify-between group">
                                         <div class="flex items-center gap-3">
                                             <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                                                 <i class="fas fa-laptop"></i>
                                             </div>
                                             <div>
                                                 <p class="text-sm font-medium text-gray-900">
                                                     {{ Str::limit($session->user_agent, 30) }}
                                                     @if($session->is_current)
                                                         <span class="ml-2 px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-[10px] font-bold uppercase tracking-wide">Current</span>
                                                     @endif
                                                 </p>
                                                 <p class="text-xs text-gray-500">{{ $session->ip_address }} • Active {{ \Carbon\Carbon::parse($session->last_activity)->diffForHumans() }}</p>
                                             </div>
                                         </div>
                                     </div>
                                 @endforeach
                             </div>
                         </div>
                    </div>
                </div>
            @endif

            {{-- NOTIFICATIONS TAB (Placeholder) --}}
            @if($activeTab === 'notifications')
                 <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
                     <div class="w-16 h-16 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-4 text-indigo-500 text-2xl">
                         <i class="fas fa-bell"></i>
                     </div>
                     <h3 class="text-xl font-bold text-gray-900 mb-2">Notifications Coming Soon</h3>
                     <p class="text-gray-500 max-w-md mx-auto">Manage your email and push notification preferences from this dashboard.</p>
                 </div>
            @endif

        </div>
    </div>
</div>
