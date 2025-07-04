<?php

namespace App\Http\Controllers;

use App\Models\AuditHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AuditController extends Controller
{
    /**
     * Cek apakah user saat ini boleh mengakses audit
     */
    protected function canAccess(AuditHistory $audit): bool
    {
        $user = Auth::user();  // Mendapatkan user yang sedang login

        // Log debug untuk memantau status akses
        \Log::debug('Current User:', ['user_id' => $user->id, 'role' => $user->role]);
        \Log::debug('Audit Info:', ['audit_user_id' => $audit->user_id]);

        // Menambahkan pengecekan untuk role admin dengan lebih jelas
        if ($user->role === 'admin') {
            \Log::debug('Access granted to admin.');
            return true; // Admin selalu bisa akses
        }

        // Periksa apakah user adalah pemilik audit
        if ($user->id === $audit->user_id) {
            \Log::debug('Access granted to owner of audit.');
            return true;
        }

        \Log::debug('Access denied.');
        return false; // Akses ditolak
    }

    /**
     * Menampilkan detail audit berdasarkan ID
     */
    public function show($id)
    {
        $user = Auth::user(); // Mendapatkan user yang sedang login

        // Log debug untuk memeriksa status login
        \Log::debug('User is authenticated:', ['user_id' => $user->id]);

        if (!$user) {
            \Log::debug('User not authenticated.');
            return redirect()->route('login')->withErrors('Anda harus login terlebih dahulu.');
        }

        $audit = AuditHistory::findOrFail($id);  // Mencari audit berdasarkan ID

        // Log debug untuk memeriksa ID audit yang akan diakses
        \Log::debug('Requested Audit ID:', ['audit_id' => $audit->id]);

        // Cek apakah user memiliki akses ke audit ini
        if (!$this->canAccess($audit)) {
            \Log::debug('Access denied for audit ID:', ['audit_id' => $audit->id]);
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Jika akses diizinkan, tampilkan halaman audit
        \Log::debug('Access granted for audit ID:', ['audit_id' => $audit->id]);
        return view('audit.show', compact('audit'));
    }

    /**
     * Ekspor audit ke PDF
     */
    public function exportPdf($id)
    {
        $audit = AuditHistory::findOrFail($id);

        // Cek apakah user memiliki akses untuk ekspor PDF
        if (!$this->canAccess($audit)) {
            abort(403, 'Anda tidak memiliki akses untuk ekspor PDF.');
        }

        // Ekspor PDF
        $pdf = Pdf::loadView('audit.pdf', compact('audit'));
        return $pdf->download("audit-{$audit->id}.pdf");
    }

    /**
     * Ekspor audit ke CSV
     */
    public function exportCsv($id)
    {
        $audit = AuditHistory::findOrFail($id);

        // Cek apakah user memiliki akses untuk ekspor CSV
        if (!$this->canAccess($audit)) {
            abort(403, 'Anda tidak memiliki akses untuk ekspor CSV.');
        }

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=audit-{$audit->id}.csv",
        ];

        $callback = function () use ($audit) {
            $handle = fopen('php://output', 'w');

            // Menulis header CSV
            fputcsv($handle, ['Issue', 'Description']);

            // Menulis data audit (misalnya issues) ke CSV
            if ($audit->relationLoaded('issues') || method_exists($audit, 'issues')) {
                foreach ($audit->issues as $issue) {
                    fputcsv($handle, [$issue->title, $issue->description ?? '']);
                }
            } else {
                // Jika tidak ada relasi issues, tulis data dummy
                fputcsv($handle, ['No issues', 'No data available']);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Analisis audit dari request user (placeholder)
     */
    public function analyze(Request $request)
    {
        $url = $request->input('url');
        
        // Logika analisis SEO bisa ditambahkan di sini
        \Log::debug('Analisis URL:', ['url' => $url]);
        
        // Lanjutkan logika analisis SEO di sini...
    }
}
