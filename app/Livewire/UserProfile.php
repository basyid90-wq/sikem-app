<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage;

class UserProfile extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $username;
    public $no_ic;
    public $current_password;
    public $password;
    public $password_confirmation;
    public $photo;
    public $profile_photo_path;

    public function mount()
    {
        $user = auth()->user();
        if ($user) {
            $user = $user->fresh();
            $this->name = $user->name;
            $this->email = $user->email;
            $this->username = $user->username;
            $this->no_ic = $user->no_ic;
            $this->profile_photo_path = $user->profile_photo_path;
        }
    }

    public function updateProfile()
    {
        $user = \App\Models\User::find(auth()->id());

        if ($this->no_ic) {
            $this->no_ic = str_replace('-', '', $this->no_ic);
        }

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'no_ic' => 'nullable|string|max:20|unique:users,no_ic,' . $user->id,
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'no_ic' => $this->no_ic,
        ];

        if ($this->photo) {
            if ($user->profile_photo_path && Storage::exists($user->profile_photo_path)) {
                Storage::delete($user->profile_photo_path);
            }
            $data['profile_photo_path'] = $this->photo->store('profile-photos', 'public');
            $this->profile_photo_path = $data['profile_photo_path'];
        }

        $user->update($data);

        session()->flash('profile_message', 'Profil berjaya dikemaskini!');
    }

    public function updatePassword()
    {
        $user = auth()->user();

        $this->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);

        session()->flash('password_message', 'Kata laluan berjaya dikemaskini!');
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}
