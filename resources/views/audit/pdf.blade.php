<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Audit SEO</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        .footer { margin-top: 40px; font-size: 12px; text-align: center; }
    </style>
</head>
<body>
    <h1>Laporan Audit SEO</h1>

    <p><strong>ID Audit:</strong> {{ $audit->id }}</p>
    <p><strong>Nama User:</strong> {{ $audit->user->name ?? 'Tidak diketahui' }}</p>
    <p><strong>URL:</strong> {{ $audit->url }}</p>
    <p><strong>Skor SEO:</strong> {{ $audit->seo_score }}/100</p>
    <p><strong>Tanggal Audit:</strong> {{ $audit->created_at->format('d M Y H:i') }}</p>

    <h3>Detail Permasalahan SEO</h3>
    <table>
        <thead>
            <tr>
                <th>Masalah</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @if($audit->relationLoaded('issues') || method_exists($audit, 'issues'))
                @foreach ($audit->issues as $issue)
                    <tr>
                        <td>{{ $issue->title }}</td>
                        <td>{{ $issue->description ?? '-' }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="2">Tidak ada data masalah SEO</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini dihasilkan secara otomatis oleh sistem Audit SEO UMKM.</p>
    </div>
</body>
</html>
