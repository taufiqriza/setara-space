<?php

namespace App\Livewire\Control\Teams;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class TeamManager extends Component
{
    use WithPagination;

    public $search = '';
    public $filterRole = '';
    public $filterStatus = '';

    // Modals
    public $showModal = false;
    public $isEditing = false;
    public $userId;
    
    // Form Fields
    public $name;
    public $email;
    public $password;
    public $employment_type = 'fulltime';
    public $role = 'staff-fulltime';
    public $is_active = true;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'employment_type' => 'required|in:fulltime,parttime',
        'role' => 'required|exists:roles,name',
    ];

    public function render()
    {
        $users = User::query()
            ->with(['roles'])
            ->when($this->search, function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterRole, function($q) {
                $q->whereHas('roles', function($r) {
                    $r->where('name', $this->filterRole);
                });
            })
            ->when($this->filterStatus !== '', function($q) {
                $q->where('is_active', $this->filterStatus === 'active');
            })
            ->latest()
            ->paginate(10);

        $roles = Role::all();

        return view('livewire.control.teams.team-manager', [
            'users' => $users,
            'roles' => $roles,
        ])->layout('layouts.control', ['title' => 'Team Management']);
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->reset(['name', 'email', 'password', 'employment_type', 'role', 'is_active', 'userId', 'isEditing']);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function editUser($id)
    {
        $this->resetValidation();
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = ''; // Don't fill password on edit
        $this->employment_type = $user->employment_type;
        $this->role = $user->roles->first()->name ?? 'staff-fulltime';
        $this->is_active = $user->is_active;
        
        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save()
    {
        $rules = $this->rules;
        if ($this->isEditing) {
            $rules['email'] = 'required|email|unique:users,email,' . $this->userId;
            $rules['password'] = 'nullable|min:6'; // Password optional on update
        }

        $this->validate($rules);

        if ($this->isEditing) {
            $user = User::findOrFail($this->userId);
            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'employment_type' => $this->employment_type,
                'is_active' => $this->is_active,
            ];
            
            if (!empty($this->password)) {
                $data['password'] = Hash::make($this->password);
            }
            
            $user->update($data);
            $user->syncRoles([$this->role]);
            
            $this->dispatch('swal:modal', [
                'type' => 'success',
                'title' => 'Updated!',
                'text' => 'Team member updated successfully.'
            ]);
        } else {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'employment_type' => $this->employment_type,
                'is_active' => $this->is_active,
            ]);
            $user->assignRole($this->role);
            
            $this->dispatch('swal:modal', [
                'type' => 'success',
                'title' => 'Created!',
                'text' => 'New team member added successfully.'
            ]);
        }

        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        if ($id === Auth::id()) {
            $this->dispatch('swal:modal', [
                'type' => 'error',
                'title' => 'Action Denied',
                'text' => 'You cannot delete your own account.'
            ]);
            return;
        }

        $this->dispatch('swal:confirm', [
            'type' => 'warning',
            'title' => 'Are you sure?',
            'text' => 'This action cannot be undone.',
            'method' => 'deleteUser', // The method to call if confirmed
            'id' => $id
        ]);
    }

    // Listener for the confirmed action
    protected $listeners = ['deleteUser'];

    public function deleteUser($id)
    {
        // Handle array wrap from event dispatch if necessary, though dispatch usually sends args cleanly
        // In Livewire 3, if passed as object {id: 1}, it comes as array or object. 
        // Let's safe cast or check.
        if (is_array($id) && isset($id['id'])) {
            $id = $id['id'];
        }

        $user = User::findOrFail($id);
        $user->delete();
        
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'Deleted!',
            'text' => 'Team member has been removed.'
        ]);
    }

    public function toggleStatus($id)
    {
        if ($id === Auth::id()) {
            return; 
        }
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'active' : 'inactive';
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'title' => 'Status Updated',
            'text' => "User is now {$status}."
        ]);
    }
}
