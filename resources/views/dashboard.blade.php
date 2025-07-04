@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="text-primary mb-0">👨‍💼 Dashboard Admin</h2>
            <small class="text-muted">Selamat datang, {{ Auth::user()->name }}!</small>
        </div>
        <div class="col-auto">
            <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary btn-sm">
                ⚙️ Edit Profil
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Audit SEO -->
        <div class="col-md-4">
            <div class="card border-start border-primary border-4 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">🔎 Audit SEO</h5>
                    <p class="card-text">Lakukan audit SEO untuk website UMKM.</p>
                    <a href="{{ route('audit') }}" class="btn btn-primary w-100">Mulai Audit</a>
                </div>
            </div>
        </div>

        <!-- Profil -->
        <div class="col-md-4">
            <div class="card border-start border-success border-4 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">👥 Profil Pengguna</h5>
                    <p class="card-text">Perbarui informasi akun Anda secara mandiri.</p>
                    <a href="{{ route('profile.edit') }}" class="btn btn-success w-100">Kelola Profil</a>
                </div>
            </div>
        </div>

        <!-- Logout -->
        <div class="col-md-4">
            <div class="card border-start border-danger border-4 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">🚪 Logout</h5>
                    <p class="card-text">Keluar dari sistem dengan aman.</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-danger w-100" type="submit">Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
