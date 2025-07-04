<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Audit SEO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light py-5">
    <div class="container">
        <div class="bg-white p-5 shadow rounded">
            <h2 class="text-center text-primary mb-4">Hasil Audit SEO</h2>

            <p class="text-center"><strong>URL:</strong> {{ $result['url'] }}</p>

            <div class="text-center mb-4">
                <span class="fs-4 fw-semibold">Skor SEO:</span>
                <span class="fs-4 fw-bold text-success">{{ $result['score'] }}/100</span>
            </div>

            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Elemen</th>
                        <th>Hasil</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Title Tag</td>
                        <td>{{ $result['title'] }}</td>
                    </tr>
                    <tr>
                        <td>Meta Description</td>
                        <td>{{ $result['description'] }}</td>
                    </tr>
                    <tr>
                        <td>Heading H1</td>
                        <td>{{ $result['h1'] }}</td>
                    </tr>
                    <tr>
                        <td>Alt Text pada Gambar</td>
                        <td>{{ $result['alt_text_score'] }}</td>
                    </tr>
                    <tr>
                        <td>Kepadatan Kata Kunci</td>
                        <td>{{ $result['keyword_density'] }}</td>
                    </tr>
                    <tr>
                        <td>Skor PageSpeed</td>
                        <td>{{ $result['pagespeed_score'] }}</td>
                    </tr>
                </tbody>
            </table>

            {{-- Menampilkan saran perbaikan jika ada --}}
            @if (count($result['saran']) > 0)
                <div class="alert alert-warning mt-4">
                    <h5 class="fw-bold">💡 Saran Perbaikan:</h5>
                    <ul class="mb-0">
                        @foreach ($result['saran'] as $note)
                            <li>{!! $note !!}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Visualisasi Skor SEO --}}
            <div class="my-5">
                <h5 class="text-center mb-3">Visualisasi Skor SEO</h5>
                <canvas id="seoChart" width="400" height="200"></canvas>
            </div>

            {{-- Tombol Export hanya untuk pengguna dengan role 'user' --}}
            @if(auth()->check() && auth()->user()->role === 'user')
                <div class="text-center mt-4">
                    <a href="{{ route('audit.export', $result['url']) }}" class="btn btn-primary">
                        📥 Export Data
                    </a>
                </div>
            @endif

            {{-- Tombol Kembali ke Halaman Sebelumnya --}}
            <div class="text-center mt-4">
                <a href="{{ url('/audit') }}" class="btn btn-secondary">🔙 Kembali</a>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('seoChart').getContext('2d');
        const seoChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($result['chartData'])) !!},
                datasets: [{
                    label: 'Skor SEO per Elemen',
                    data: {!! json_encode(array_values($result['chartData'])) !!},
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                        'rgba(46, 204, 113, 0.7)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(46, 204, 113, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 40
                    }
                }
            }
        });
    </script>
</body>
</html>
