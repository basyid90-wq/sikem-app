<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class PengurusanPengguna extends Component
{
    use WithPagination;

    public $search = '';
    public $isFormOpen = false;
    public $isViewOpen = false;

    public $userId;
    public $name;
    public $email;
    public $password;
    public $role;
    public $daerah_id = null;
    public $senarai_daerah = [];

    public $selectedUser;

    protected $queryString = ['search' => ['except' => '']];

    public function mount()
    {
        $this->senarai_daerah = \App\Models\Daerah::all();
    }

    public function getAllowedRolesProperty()
    {
        $user = auth()->user();
        if ($user->hasRole('super_admin')) {
            return Role::all();
        } elseif ($user->hasRole('kudd')) {
            return Role::whereIn('name', ['mubaligh', 'guru_apim', 'mualaf'])->get();
        } elseif ($user->hasRole('mubaligh')) {
            return Role::whereIn('name', ['guru_apim', 'mualaf'])->get();
        } elseif ($user->hasRole('guru_apim')) {
            return Role::whereIn('name', ['mualaf'])->get();
        }
        return collect();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = User::query()
            ->select('users.*')
            ->leftJoin('model_has_roles', function($join) {
                $join->on('users.id', '=', 'model_has_roles.model_id')
                     ->where('model_has_roles.model_type', '=', User::class);
            })
            ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where(function ($q) {
                $q->where('users.name', 'like', '%' . $this->search . '%')
                  ->orWhere('users.email', 'like', '%' . $this->search . '%');
            });

        $currentUser = auth()->user();
        
        if (!$currentUser->hasRole('super_admin')) {
            $hiddenRoles = ['super_admin'];
            
            if ($currentUser->hasRole('guru_apim')) {
                $hiddenRoles = array_merge($hiddenRoles, ['kudd', 'mubaligh']);
            } elseif ($currentUser->hasRole('mubaligh')) {
                $hiddenRoles = array_merge($hiddenRoles, ['kudd']);
            }
            
            $query->where(function($q) use ($hiddenRoles) {
                $q->whereNotIn('roles.name', $hiddenRoles)
                  ->orWhereNull('roles.name');
            });
        }

        $users = $query->orderByRaw("
                CASE 
                    WHEN roles.name = 'super_admin' THEN 1
                    WHEN roles.name = 'kudd' THEN 2
                    WHEN roles.name = 'mubaligh' THEN 3
                    WHEN roles.name = 'guru_apim' THEN 4
                    WHEN roles.name = 'mualaf' THEN 5
                    ELSE 6
                END
            ")
            ->paginate(10);

        return view('livewire.pengurusan-pengguna', [
            'users' => $users,
            'roles' => $this->allowedRoles,
        ])->extends('layouts.app')->section('content');
    }

    public function openForm($id = null)
    {
        $this->resetValidation();
        $this->userId = $id;

        if ($id) {
            $user = User::findOrFail($id);
            $this->name = $user->name;
            $this->email = $user->email;
            $this->password = '';
            $this->role = $user->roles->first()?->name ?? '';
            $this->daerah_id = $user->daerah_id;
        } else {
            $this->name = '';
            $this->email = '';
            $this->password = '';
            $this->role = '';
            $this->daerah_id = null;
        }

        $this->isFormOpen = true;
    }

    public function closeForm()
    {
        $this->isFormOpen = false;
        $this->userId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = '';
        $this->daerah_id = null;
    }

    public function viewUser($id)
    {
        $this->selectedUser = User::findOrFail($id);
        $this->isViewOpen = true;
    }

    public function closeView()
    {
        $this->isViewOpen = false;
        $this->selectedUser = null;
    }

    public function resetPasswordDefault($id)
    {
        $user = User::findOrFail($id);
        if ($user->hasRole('super_admin')) {
            session()->flash('error', 'Anda tidak boleh me-reset kata laluan Super Admin!');
            return;
        }

        $user->update([
            'password' => Hash::make('sikem1234')
        ]);

        session()->flash('message', 'Kata laluan berjaya di-reset kepada: sikem1234');
        $this->closeView();
    }

    public function save()
    {
        $allowedRoleNames = $this->allowedRoles->pluck('name')->toArray();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->userId,
            'role' => ['required', 'in:' . implode(',', $allowedRoleNames)],
            'daerah_id' => [
                $this->role !== 'super_admin' ? 'required' : 'nullable',
                'exists:daerahs,id'
            ],
        ];

        if (!$this->userId) {
            $rules['password'] = 'required|string|min:6';
        } else {
            $rules['password'] = 'nullable|string|min:6';
        }

        $this->validate($rules);

        if ($this->userId) {
            $user = User::findOrFail($this->userId);
            $user->name = $this->name;
            $user->email = $this->email;
            if (!empty($this->password)) {
                $user->password = Hash::make($this->password);
            }
            $user->daerah_id = $this->role === 'super_admin' ? null : $this->daerah_id;
            $user->save();

            $user->syncRoles([$this->role]);

            session()->flash('message', 'Pengguna berjaya dikemaskini!');
        } else {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'daerah_id' => $this->role === 'super_admin' ? null : $this->daerah_id,
            ]);

            $user->assignRole($this->role);

            session()->flash('message', 'Pengguna berjaya didaftarkan!');
        }

        $this->closeForm();
    }

    public function delete($id)
    {
        if ($id == auth()->id()) {
            session()->flash('error', 'Anda tidak boleh memadam akaun sendiri!');
            return;
        }

        $user = User::findOrFail($id);
        $user->delete();

        session()->flash('message', 'Pengguna berjaya dipadam!');
    }
}
