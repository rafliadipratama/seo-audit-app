@extends('layouts.app')

@section('title', 'Panduan SEO untuk UMKM')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col text-center">
            <h2 class="fw-bold text-primary">📈 Panduan SEO untuk Website UMKM</h2>
            <p class="text-muted">Pelajari strategi dasar agar website UMKM Anda mudah ditemukan di Google.</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Section 1 -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title text-success">🔍 Riset Kata Kunci</h5>
                    <p class="card-text">Gunakan kata kunci yang sering dicari pelanggan potensial. Tools seperti Google Keyword Planner, Ubersuggest, atau Ahrefs bisa membantu.</p>
                    <ul>
                        <li>Gunakan kata kunci di judul, deskripsi, dan isi artikel.</li>
                        <li>Hindari penumpukan kata kunci (keyword stuffing).</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Section 2 -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title text-danger">🖼️ Optimasi Gambar</h5>
                    <p class="card-text">Setiap gambar harus memiliki atribut <code>alt</code> yang mendeskripsikan konten gambar. Ini meningkatkan aksesibilitas dan SEO.</p>
                    <ul>
                        <li>Gunakan format gambar yang ringan (webp, jpg).</li>
                        <li>Pastikan ukuran gambar tidak terlalu besar agar website cepat dimuat.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Section 3 -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title text-primary">⚡ Kecepatan Website</h5>
                    <p class="card-text">Gunakan Google PageSpeed Insights untuk mengecek performa situs Anda. Website yang lambat menurunkan ranking SEO.</p>
                    <ul>
                        <li>Minify CSS dan JavaScript.</li>
                        <li>Gunakan cache dan CDN.</li>
                        <li>Optimalkan hosting.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Section 4 -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title text-warning">📱 Mobile Friendly</h5>
                    <p class="card-text">Pastikan website bisa dibuka dan berfungsi dengan baik di perangkat mobile. Google memprioritaskan situs yang responsif.</p>
                    <ul>
                        <li>Gunakan desain responsif (Bootstrap, Tailwind, dsb).</li>
                        <li>Hindari teks terlalu kecil dan tombol yang berdekatan.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Section 5 -->
        <div class="col-12">
            <div class="card border-0 bg-light p-4 mt-4">
                <h4 class="text-center text-success">📌 Tips Tambahan</h4>
                <ul class="mt-3">
                    <li>Perbarui konten secara berkala.</li>
                    <li>Buat blog/artikel yang relevan dengan bisnis Anda.</li>
                    <li>Pastikan struktur URL sederhana dan mengandung kata kunci.</li>
                    <li>Tambahkan meta title dan meta description yang menarik.</li>
                </ul>
                <div class="text-center mt-4">
                    <a href="{{ route('audit') }}" class="btn btn-primary btn-lg">
                        🚀 Lakukan Audit SEO Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
