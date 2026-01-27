<div class="h-screen flex flex-col overflow-hidden">
    {{-- Header --}}
    <header class="h-14 bg-white border-b border-gray-200 flex items-center justify-between px-4 flex-shrink-0">
        <div class="flex items-center gap-4">
            <button onclick="window.toggleSidebar()" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 text-gray-600">
                <i class="fas fa-bars"></i>
            </button>
            <div>
                <h1 class="text-xl font-semibold text-gray-900">Team Management</h1>
            </div>
        </div>
        <div>
           <button wire:click="openModal" class="bg-space-600 hover:bg-space-700 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-md shadow-space-200 transition-all flex items-center gap-2">
               <i class="fas fa-plus"></i> Add Member
           </button>
        </div>
    </header>

    {{-- Main Content --}}
    <div class="flex-1 overflow-y-auto p-4 md:p-6 space-y-6 bg-gray-50">
        
        {{-- Filters --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex flex-col md:flex-row gap-4 justify-between items-center">
            <div class="relative w-full md:w-96">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search by name or email..." class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-200 focus:border-space-500 focus:ring-2 focus:ring-space-200 transition-all outline-none">
            </div>
            
            <div class="flex items-center gap-3 w-full md:w-auto overflow-x-auto">
                <select wire:model.live="filterRole" class="px-3 py-2 rounded-lg border border-gray-200 bg-white text-sm focus:border-space-500 outline-none">
                    <option value="">All Roles</option>
                    @foreach($roles as $r)
                        <option value="{{ $r->name }}">{{ ucfirst(str_replace('-', ' ', $r->name)) }}</option>
                    @endforeach
                </select>
                
                <select wire:model.live="filterStatus" class="px-3 py-2 rounded-lg border border-gray-200 bg-white text-sm focus:border-space-500 outline-none">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>

        {{-- Users Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase text-gray-500 font-bold tracking-wider">
                            <th class="px-6 py-4">Staff Member</th>
                            <th class="px-6 py-4">Role</th>
                            <th class="px-6 py-4">Employment</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Joined</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($users as $user)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-space-100 to-space-200 border-2 border-white shadow-sm flex items-center justify-center text-sm font-bold text-space-700">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $roleName = $user->roles->first()->name ?? 'No Role';
                                    $roleColor = match($roleName) {
                                        'superadmin' => 'bg-purple-100 text-purple-700 border-purple-200',
                                        'staff-fulltime' => 'bg-blue-100 text-blue-700 border-blue-200',
                                        'staff-parttime' => 'bg-orange-100 text-orange-700 border-orange-200',
                                        default => 'bg-gray-100 text-gray-700 border-gray-200'
                                    };
                                @endphp
                                <span class="px-2.5 py-1 rounded-md text-xs font-bold border {{ $roleColor }}">
                                    {{ ucfirst(str_replace('-', ' ', $roleName)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-gray-700 capitalize flex items-center gap-2">
                                    @if($user->employment_type === 'fulltime')
                                        <i class="fas fa-briefcase text-gray-400 text-xs"></i>
                                    @else
                                        <i class="fas fa-clock text-gray-400 text-xs"></i>
                                    @endif
                                    {{ $user->employment_type ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <button wire:click="toggleStatus({{ $user->id }})" 
                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $user->is_active ? 'bg-green-500' : 'bg-gray-200' }}"
                                    {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                    <span class="sr-only">Use setting</span>
                                    <span aria-hidden="true" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $user->is_active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                </button>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-500">{{ $user->created_at->format('d M Y') }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="editUser({{ $user->id }})" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-blue-50 text-blue-600 transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @if($user->id !== auth()->id())
                                    <button wire:click="confirmDelete({{ $user->id }})" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-red-50 text-red-600 transition-colors">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="fas fa-users-slash text-4xl text-gray-300"></i>
                                    <p>No team members found.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    {{-- Create/Edit Modal --}}
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeModal"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
                            {{ $isEditing ? 'Edit Team Member' : 'Add New Member' }}
                        </h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-500">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <form wire:submit.prevent="save" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input wire:model="name" type="text" class="w-full rounded-lg border-gray-300 focus:border-space-500 focus:ring-space-500 shadow-sm transition-colors" placeholder="e.g. John Doe">
                            @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input wire:model="email" type="email" class="w-full rounded-lg border-gray-300 focus:border-space-500 focus:ring-space-500 shadow-sm transition-colors" placeholder="email@example.com">
                            @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Password 
                                @if($isEditing) <span class="text-xs text-gray-400 font-normal">(Leave blank to keep current)</span> @endif
                            </label>
                            <input wire:model="password" type="password" class="w-full rounded-lg border-gray-300 focus:border-space-500 focus:ring-space-500 shadow-sm transition-colors" placeholder="••••••••">
                            @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                <select wire:model="role" class="w-full rounded-lg border-gray-300 focus:border-space-500 focus:ring-space-500 shadow-sm transition-colors">
                                    @foreach($roles as $r)
                                        <option value="{{ $r->name }}">{{ ucfirst(str_replace('-', ' ', $r->name)) }}</option>
                                    @endforeach
                                </select>
                                @error('role') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Employment</label>
                                <select wire:model="employment_type" class="w-full rounded-lg border-gray-300 focus:border-space-500 focus:ring-space-500 shadow-sm transition-colors">
                                    <option value="fulltime">Full Time</option>
                                    <option value="parttime">Part Time</option>
                                </select>
                                @error('employment_type') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2 pt-2">
                             <input wire:model="is_active" type="checkbox" id="is_active" class="rounded border-gray-300 text-space-600 focus:ring-space-500">
                             <label for="is_active" class="text-sm text-gray-700">Account is Active</label>
                        </div>
                        
                        <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense pt-4 border-t border-gray-100">
                            <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-space-600 text-base font-medium text-white hover:bg-space-700 focus:outline-none sm:col-start-2 sm:text-sm transition-colors">
                                {{ $isEditing ? 'Save Changes' : 'Create Member' }}
                            </button>
                            <button type="button" wire:click="closeModal" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:col-start-1 sm:text-sm transition-colors">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
