<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithPagination;

    public $search = '';

    public function ubahRole($userId, $newLevel)
    {
        // Pastikan nilai yang masuk adalah 0 atau 1
        $newLevel = intval($newLevel);
        if (!in_array($newLevel, [User::ROLE_USER, User::ROLE_ADMIN])) {
            return;
        }

        $user = User::find($userId);
        if ($user && !$user->isSuperAdmin()) { // Pastikan bukan super admin
            $user->update(['is_admin' => $newLevel]);
            session()->flash('message', 'Level admin user berhasil diubah.');
        } else {
            session()->flash('error', 'Level Super Admin tidak dapat diubah.');
        }
    }

    public function render()
    {
        // ... logika render sama seperti sebelumnya ...
        $users = User::where('id', '!=', auth()->id())
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->latest()->paginate(10);

        return view('livewire.admin.user-management', ['users' => $users])
            ->layout('layouts.admin');
    }
}
