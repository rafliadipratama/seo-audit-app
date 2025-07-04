@extends('layouts.user')

@section('title', 'Profil Pengguna')

@section('content')
<div class="container py-4">
    <h2 class="text-primary">👤 Profil Pengguna</h2>

    <div class="card shadow-lg mb-4">
        <div class="card-body">
            <h5 class="card-title">Informasi Pengguna</h5>
            <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
            <p><strong>Peran:</strong> {{ ucfirst(Auth::user()->role) }}</p>
            <p><strong>Terdaftar Sejak:</strong> {{ Auth::user()->created_at->format('d M Y') }}</p>
            <p><strong>Terakhir Masuk:</strong> {{ Auth::user()->last_login_at ? Auth::user()->last_login_at->format('d M Y H:i') : 'Belum ada' }}</p>
        </div>
    </div>

    <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">✏️ Edit Profil</a>
</div>
@endsection
