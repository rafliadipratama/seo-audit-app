@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <h3 class="text-center text-primary mb-4">🔍 Audit SEO Website UMKM</h3>

                    {{-- Menampilkan pesan error jika ada --}}
                    @if (session('error'))
                        <div class="alert alert-danger text-center">{{ session('error') }}</div>
                    @endif

                    {{-- Formulir Input URL --}}
                    <form method="POST" action="{{ route('audit.analyze') }}">
                        @csrf

                        {{-- Input URL --}}
                        <div class="mb-3">
                            <label for="url" class="form-label">Masukkan URL Website</label>
                            <div class="input-group">
                                <span class="input-group-text">🔗</span>
                                <input 
                                    type="url" 
                                    name="url" 
                                    id="url" 
                                    class="form-control @error('url') is-invalid @enderror" 
                                    placeholder="https://umkmcontoh.com" 
                                    required
                                    value="{{ old('url') }}"
                                    aria-describedby="urlHelp">
                            </div>
                            <div id="urlHelp" class="form-text">Gunakan format lengkap (contoh: https://umkmcontoh.com)</div>

                            {{-- Menampilkan pesan error jika URL tidak sesuai format --}}
                            @error('url')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Tombol Submit --}}
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                                🚀 Mulai Audit
                            </button>
                        </div>
                    </form>

                    {{-- Footer --}}
                    <div class="text-center mt-4">
                        <small class="text-muted">Aplikasi Audit SEO untuk mendukung digitalisasi UMKM</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
