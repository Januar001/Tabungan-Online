<div>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Level Admin</th>
                            <th width="200px">Ubah Level</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    {{-- Terjemahkan angka menjadi teks --}}
                                    @if($user->isSuperAdmin())
                                        <span class="badge bg-danger">Super Admin</span>
                                    @elseif($user->isAdmin())
                                        <span class="badge bg-primary">Admin</span>
                                    @else
                                        <span class="badge bg-secondary">User</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!$user->isSuperAdmin())
                                        <select class="form-select form-select-sm" 
                                            wire:change="ubahRole({{ $user->id }}, $event.target.value)">
                                            {{-- Gunakan konstanta untuk value agar lebih aman --}}
                                            <option value="{{ \App\Models\User::ROLE_USER }}" @if($user->is_admin == \App\Models\User::ROLE_USER) selected @endif>User</option>
                                            <option value="{{ \App\Models\User::ROLE_ADMIN }}" @if($user->is_admin == \App\Models\User::ROLE_ADMIN) selected @endif>Admin</option>
                                        </select>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            @endforelse
                    </tbody>
                </table>
            </div>
            </div>
    </div>
</div>