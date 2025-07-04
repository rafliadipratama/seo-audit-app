@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <!-- Card Total Audit -->
        <div class="col-md-4">
            <div class="card text-white bg-primary shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Total Audit</h5>
                    <p class="card-text fs-3">{{ $totalAudit }}</p>
                    <i class="bi bi-bar-chart-line display-4"></i>
                </div>
            </div>
        </div>

        <!-- Card Skor Rata-rata -->
        <div class="col-md-4">
            <div class="card text-white bg-success shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Skor Rata-rata</h5>
                    <p class="card-text fs-3">{{ number_format($averageScore, 2) }}/100</p>
                    <i class="bi bi-graph-up-arrow display-4"></i>
                </div>
            </div>
        </div>

        <!-- Card Audit Terakhir -->
        <div class="col-md-4">
            <div class="card text-white bg-warning shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Audit Terakhir</h5>
                    @if($auditHistories->isNotEmpty())
                        <p class="card-text fs-5">{{ $auditHistories->first()->url }} - {{ $auditHistories->first()->seo_score }}/100</p>
                    @else
                        <p class="card-text fs-5">Belum ada audit terbaru</p>
                    @endif
                    <i class="bi bi-clock-history display-4"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Audit -->
    <div class="card">
        <div class="card-header bg-light fw-bold">
            Riwayat Audit Terakhir
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>URL</th>
                        <th>Skor</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($auditHistories as $history)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $history->url }}</td>
                            <td>{{ $history->seo_score }}</td>
                            <td>{{ $history->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('audit.show', $history->id) }}" class="btn btn-sm btn-outline-primary">Lihat</a>
                                <!-- Tombol Ekspor untuk setiap audit -->
                                <a href="{{ route('audit.export.pdf', $history->id) }}" class="btn btn-sm btn-outline-success">📥 PDF</a>
                                <a href="{{ route('audit.export.csv', $history->id) }}" class="btn btn-sm btn-outline-primary">📥 CSV</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Grafik Skor SEO -->
    <div class="card mt-4">
        <div class="card-header bg-white fw-bold">
            Grafik Skor SEO
        </div>
        <div class="card-body">
            <canvas id="seoScoreChart" height="150"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('seoScoreChart').getContext('2d');
    var seoScoreChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Skor SEO',
                data: {!! json_encode($chartData) !!},
                borderColor: 'rgba(75, 192, 192, 1)',
                fill: false,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Tanggal'
                    }
                },
                y: {
                    min: 0,
                    max: 100,
                    title: {
                        display: true,
                        text: 'Skor SEO'
                    }
                }
            }
        }
    });
</script>
@endsection
