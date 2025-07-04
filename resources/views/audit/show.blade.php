@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Hasil Audit untuk URL: {{ $audit->url }}</h2>
    <p><strong>Skor SEO:</strong> {{ $audit->seo_score }}/100</p>

    <!-- Menampilkan Saran -->
    <h3>Saran Perbaikan:</h3>
    <ul>
        @forelse ($audit->saran as $saran)
            <li>{{ $saran }}</li>
        @empty
            <li>Tidak ada saran perbaikan untuk URL ini.</li>
        @endforelse
    </ul>

    <!-- Menampilkan Detail lainnya -->
    <p><strong>URL:</strong> {{ $audit->url }}</p>
    <p><strong>Skor SEO:</strong> {{ $audit->seo_score }}</p>
    <p><strong>Waktu Audit:</strong> {{ $audit->created_at->format('d-m-Y H:i:s') }}</p>

    <!-- Tombol Kembali ke Daftar Audit -->
    <a href="{{ route('audit') }}" class="btn btn-primary mt-3">Kembali ke Daftar Audit</a>
</div>
@endsection
