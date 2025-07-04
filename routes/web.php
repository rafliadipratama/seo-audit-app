<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SeoAuditController;
use App\Http\Controllers\Auth\LoginAdminController;
use App\Http\Controllers\Auth\LoginUserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuditController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\AuditHistory;
use App\Exports\AuditExport;
use App\Exports\UserAuditExport; // ✅ Tambahan untuk ekspor user

// 🌐 Root redirect ke dashboard
Route::get('/', fn() => redirect('/dashboard'));

// 🔐 Pilihan login
Route::get('/login', fn() => view('auth.choose-login'))->name('login');

// 🔐 Login USER
Route::get('/login/user', [LoginUserController::class, 'showLoginForm'])->name('login.user');
Route::post('/login/user', [LoginUserController::class, 'login']);

// 🔐 Login ADMIN
Route::get('/login/admin', [LoginAdminController::class, 'showLoginForm'])->name('login.admin');
Route::post('/login/admin', [LoginAdminController::class, 'login']);

// 📘 Panduan SEO
Route::get('/panduan', fn() => view('panduan'))->name('panduan');

// ✅ Grup route yang membutuhkan login
Route::middleware(['auth', 'verified'])->group(function () {

    // 🧭 Redirect dashboard sesuai role
    Route::get('/dashboard', function () {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    })->name('dashboard');

    // 👤 Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | 🧑‍🎓 ROUTE USER
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:user')->group(function () {
        // Form input URL untuk audit SEO
        Route::get('/audit', [SeoAuditController::class, 'form'])->name('audit');
        Route::post('/audit', [SeoAuditController::class, 'analyze'])->name('audit.analyze');

        // 🔄 Ekspor audit per ID ke PDF atau CSV
        Route::get('/audit/{id}/export/pdf', [AuditController::class, 'exportPdf'])->name('audit.export.pdf');
        Route::get('/audit/{id}/export/csv', [AuditController::class, 'exportCsv'])->name('audit.export.csv');

        // ✅ Ekspor semua audit milik user yang sedang login
        Route::get('/audit/export', function () {
            $user = auth()->user();
            return Excel::download(new UserAuditExport($user->id), 'audit_user_'.$user->id.'.xlsx');
        })->name('audit.export.user');

        // Dashboard User
        Route::get('/user/dashboard', function () {
            $user = auth()->user();
            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May'];
            $scores = AuditHistory::where('user_id', $user->id)
                                  ->orderBy('created_at')
                                  ->take(5)
                                  ->pluck('seo_score');
            return view('user-dashboard', compact('months', 'scores'));
        })->name('user.dashboard');

        // Tampilkan audit berdasarkan ID
        Route::get('/audit/{id}', [AuditController::class, 'show'])->name('audit.show');
    });

    /*
    |--------------------------------------------------------------------------
    | 🧑‍💼 ROUTE ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {
        // Dashboard Admin
        Route::get('/admin/dashboard', [AdminController::class, 'showDashboard'])->name('admin.dashboard');

        // ✅ Ekspor semua audit (khusus admin)
        Route::get('/audit/export', function () {
            return Excel::download(new AuditExport, 'audit_results.xlsx');
        })->name('audit.export');
    });
});

// 🔐 Autentikasi Laravel Breeze
require __DIR__.'/auth.php';
