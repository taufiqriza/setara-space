<div class="min-h-screen flex flex-col">
    {{-- Header --}}
    <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 flex-shrink-0 sticky top-0 z-30">
        <div class="flex items-center gap-4">
            <button onclick="window.toggleSidebar()" class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 hover:bg-gray-100 text-gray-600 transition-colors shadow-sm ring-1 ring-gray-200">
                <i class="fas fa-bars"></i>
            </button>
            <div>
                <h1 class="text-xl font-bold text-gray-900">Merchant Integrations</h1>
            </div>
        </div>
    </header>

    <div class="flex-1 p-6 max-w-7xl mx-auto w-full">
        
        {{-- Intro --}}
        <div class="mb-8">
            <h2 class="text-lg font-bold text-gray-900">Available Platforms</h2>
            <p class="text-gray-500 text-sm">Connect your POS with food delivery platforms to sync orders and revenue.</p>
        </div>

        {{-- Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($merchants as $merchant)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow p-6 flex flex-col h-full relative overflow-hidden group">
                    
                    {{-- Status Badge --}}
                    <div class="absolute top-4 right-4">
                        @php
                            $integration = $merchant->integrations->first();
                            $isActive = $integration && $integration->is_enabled;
                            $status = $merchant->status === 'coming_soon' ? 'Coming Soon' : ($isActive ? 'Active' : 'Inactive');
                            $color = $merchant->status === 'coming_soon' ? 'gray' : ($isActive ? 'green' : 'red');
                        @endphp
                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wide bg-{{ $color }}-100 text-{{ $color }}-700">
                            {{ $status }}
                        </span>
                    </div>

                    {{-- Logo --}}
                    <div class="w-16 h-16 rounded-xl bg-gray-50 p-2 mb-4 flex items-center justify-center">
                        <img src="{{ $merchant->logo_url }}" alt="{{ $merchant->name }}" class="w-full h-full object-contain">
                    </div>

                    {{-- Info --}}
                    <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $merchant->name }}</h3>
                    <p class="text-sm text-gray-500 mb-6 flex-1">
                        @if($merchant->slug == 'gofood')
                            Official GoBiz API Integration. Sync orders & menus.
                        @elseif($merchant->slug == 'grabfood')
                            Connect with GrabFood Merchant platform.
                        @else
                            ShopeeFood Partner API.
                        @endif
                    </p>

                    {{-- Actions --}}
                    <div class="mt-auto pt-4 border-t border-gray-100 flex gap-3">
                        @if($merchant->status === 'active' || $merchant->status === 'inactive')
                            <button wire:click="configure({{ $merchant->id }})" 
                                    class="flex-1 px-4 py-2 bg-space-600 hover:bg-space-700 text-white rounded-xl text-sm font-bold transition-all shadow-lg shadow-space-500/20">
                                Configure
                            </button>
                            @if($isActive)
                            <button wire:click="testConnection({{ $merchant->id }})" 
                                    class="w-10 h-full flex items-center justify-center rounded-xl border border-gray-200 hover:bg-gray-50 text-gray-600"
                                    title="Test Connection">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                            @endif
                        @else
                            <button disabled class="w-full px-4 py-2 bg-gray-100 text-gray-400 rounded-xl text-sm font-bold cursor-not-allowed">
                                Not Available
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Configuration Modal --}}
        @if($isConfigModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
             x-data
             @keydown.escape.window="$wire.set('isConfigModalOpen', false)">
            
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden transform transition-all"
                 @click.outside="$wire.set('isConfigModalOpen', false)">
                
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900">
                        Configure {{ $configuringMerchant->name }}
                    </h3>
                    <button wire:click="$set('isConfigModalOpen', false)" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="p-6 space-y-4">
                    {{-- Status Toggle --}}
                    <div class="flex items-center justify-between p-4 bg-blue-50/50 rounded-xl border border-blue-100">
                        <div>
                            <p class="text-sm font-bold text-gray-900">Enable Integration</p>
                            <p class="text-xs text-gray-500">Accept orders from this platform</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="is_enabled" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    {{-- Outlet ID --}}
                    <div class="space-y-1">
                        <label class="text-sm font-medium text-gray-700">Outlet ID (GoBiz/Grab ID)</label>
                        <input type="text" wire:model="outlet_id" placeholder="e.g. 123456" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-space-500 focus:ring-2 focus:ring-space-200 outline-none transition-all">
                        @error('outlet_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    {{-- Credentials --}}
                    <div class="space-y-3 pt-2">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">API Credentials (Confidential)</h4>
                        
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-gray-600">Client ID / App ID</label>
                            <input type="text" wire:model="client_id" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-space-500 focus:ring-2 focus:ring-space-200 outline-none transition-all font-mono text-sm">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-xs font-medium text-gray-600">Client Secret</label>
                                <input type="password" wire:model="client_secret" placeholder="••••••••" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-space-500 focus:ring-2 focus:ring-space-200 outline-none transition-all font-mono text-sm">
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-medium text-gray-600">Relay Secret (Webhook)</label>
                                <input type="password" wire:model="relay_secret" placeholder="••••••••" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-space-500 focus:ring-2 focus:ring-space-200 outline-none transition-all font-mono text-sm">
                            </div>
                        </div>
                        <p class="text-[10px] text-gray-400">Leave secrets blank to keep existing values.</p>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                    <button wire:click="$set('isConfigModalOpen', false)" class="px-4 py-2 text-gray-600 font-medium hover:bg-gray-100 rounded-lg transition-colors">
                        Cancel
                    </button>
                    <button wire:click="saveConfiguration" class="px-6 py-2 bg-space-600 hover:bg-space-700 text-white rounded-lg font-bold shadow-lg shadow-space-500/30 transition-all hover:scale-[1.02]">
                        Save & Connect
                    </button>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
