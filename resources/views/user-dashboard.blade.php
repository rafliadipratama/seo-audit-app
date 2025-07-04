@extends('layouts.user')

@section('title', 'Dashboard Pengguna')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col">
            <h2 class="text-primary fw-bold">👤 Dashboard Pengguna</h2>
            <p class="text-muted">Selamat datang, <strong>{{ Auth::user()->name }}</strong>! Semoga harimu menyenangkan!</p>
        </div>
        <div class="col text-end">
            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">⚙️ Edit Profil</a>
        </div>
    </div>

    <!-- Analytic Dashboard Section -->
    <div class="row g-4 mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-start border-info border-3">
                <div class="card-body">
                    <h5 class="card-title text-success"><i class="bi bi-bar-chart-line"></i> 📊 Analitik SEO Website</h5>
                    <p class="card-text">Berikut adalah grafik tren SEO website Anda selama 5 bulan terakhir. Tinjau kinerja SEO Anda dan temukan area yang perlu diperbaiki!</p>

                    <!-- Grafik dalam container dengan tinggi tetap -->
                    <div class="chart-container" style="position: relative; height: 300px; width: 100%; overflow: hidden;">
                        <canvas id="seoScoreChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Audit & Panduan Section -->
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-lg border-start border-info border-3">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="bi bi-search"></i> 🔍 Audit Website</h5>
                    <p class="card-text">Cek SEO website kamu secara instan dan dapatkan insight perbaikan. Perbaiki elemen-elemen penting untuk hasil maksimal!</p>
                    <a href="{{ route('audit') }}" class="btn btn-primary w-100">Mulai Audit</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-lg border-start border-warning border-3">
                <div class="card-body">
                    <h5 class="card-title text-warning"><i class="bi bi-file-earmark-earbuds"></i> 📄 Panduan</h5>
                    <p class="card-text">Pelajari cara meningkatkan SEO website UMKM Anda dengan mengikuti panduan lengkap yang kami sediakan.</p>
                    <a href="{{ route('panduan') }}" class="btn btn-warning w-100">Lihat Panduan</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
window.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('seoScoreChart').getContext('2d');

    const seoScoreChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($months ?? []),
            datasets: [{
                label: 'Skor SEO Bulanan',
                data: @json($scores ?? []),
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Skor: ' + context.raw;
                        }
                    }
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Bulan'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Skor SEO'
                    },
                    min: 0,
                    max: 100
                }
            }
        }
    });
});
</script>
@endsection
