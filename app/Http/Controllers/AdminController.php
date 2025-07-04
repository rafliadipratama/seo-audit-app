<?php

namespace App\Http\Controllers;

use App\Models\AuditHistory;

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard admin dengan data audit.
     */
    public function showDashboard()
    {
        // Mengambil jumlah total audit
        $totalAudit = AuditHistory::count();

        // Mengambil rata-rata skor SEO
        $averageScore = AuditHistory::avg('seo_score') ?? 0; // Menangani nilai null jika tidak ada data

        // Mengambil 5 audit terbaru
        $auditHistories = AuditHistory::with('user') // Pastikan relasi 'user' ada di model AuditHistory
                                      ->latest()
                                      ->take(5)
                                      ->get(['id', 'user_id', 'url', 'seo_score', 'created_at']); // Ambil hanya kolom yang dibutuhkan

        // Menyiapkan data untuk grafik Chart.js
        $chartLabels = $auditHistories->pluck('created_at')->map(function ($date) {
            return $date->format('M d'); // Format tanggal menjadi 'Bulan Tanggal'
        })->toArray();

        // Mengambil skor SEO dari setiap audit untuk grafik
        $chartData = $auditHistories->pluck('seo_score')->toArray();

        // Kirim semua data ke tampilan
        return view('admin.dashboard', compact(
            'totalAudit',
            'averageScore',
            'auditHistories',
            'chartLabels',
            'chartData'
        ));
    }
}
