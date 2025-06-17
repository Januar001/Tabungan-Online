{{-- File: resources/views/profile/edit.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">

            <h2 class="mb-4">Edit Profile</h2>

            {{-- Card untuk Update Informasi Profil --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body p-4">
                   @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Card untuk Update Password --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body p-4">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Card untuk Hapus Akun --}}
            <div class="card shadow-sm mb-4">
                 <div class="card-body p-4">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</div>
@endsection