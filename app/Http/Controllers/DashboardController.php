<?php

use App\Models\AuditHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

public function index()
{
    $userId = Auth::id();

    // Ambil 5 data terakhir berdasarkan tanggal untuk user saat ini
    $data = AuditHistory::where('user_id', $userId)
        ->orderBy('created_at', 'asc')
        ->take(5)
        ->get();

    // Ambil nama bulan dari tanggal created_at
    $months = $data->map(function ($item) {
        return Carbon::parse($item->created_at)->translatedFormat('M'); // Jan, Feb, dst
    });

    // Ambil nilai dari kolom `seo_score`
    $scores = $data->pluck('seo_score');

    return view('user.dashboard', compact('months', 'scores'));
}
