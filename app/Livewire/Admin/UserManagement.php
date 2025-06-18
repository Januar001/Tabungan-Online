<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithPagination;

    // Properti untuk Pencarian
    public $search = '';

    // Properti untuk form modal
    public $name, $email, $password, $is_admin;
    public $modalTitle = '';
    public $userId;

    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function ubahRole($userId, $newLevel)
    {
        $newLevel = intval($newLevel);
        if (!in_array($newLevel, [User::ROLE_USER, User::ROLE_ADMIN])) {
            return;
        }
        $user = User::find($userId);
        if ($user && !$user->isSuperAdmin()) {
            $user->update(['is_admin' => $newLevel]);
            session()->flash('message', 'Level akses user berhasil diubah.');
        } else {
            session()->flash('error', 'Level Super Admin tidak dapat diubah.');
        }
    }
    
    public function openAddModal()
    {
        $this->resetValidation();
        $this->reset(['name', 'email', 'password', 'is_admin', 'userId']); 
        $this->modalTitle = 'Tambah User Baru';
    }

    public function simpanUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'is_admin' => 'required|integer|in:0,1',
        ]);
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'is_admin' => $this->is_admin,
        ]);
        session()->flash('message', 'User baru berhasil ditambahkan.');
        $this->dispatch('close-modal');
    }

    public function hapusUser($userId)
    {
        $user = User::find($userId);

        if ($user) {
            // Keamanan tambahan: pastikan superadmin tidak bisa dihapus
            if ($user->isSuperAdmin()) {
                session()->flash('error', 'Role Super Admin tidak dapat dihapus.');
                return;
            }

            $user->delete();
            session()->flash('message', 'User berhasil dihapus.');
        }
    }

    public function render()
    {
        $users = User::where('id', '!=', auth()->id())
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);
            
        return view('livewire.admin.user-management', [
            'users' => $users
        ])->layout('layouts.admin');
    }
}