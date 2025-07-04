<?php

namespace App\Http\Controllers;

use App\Models\AuditHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class SeoAuditController extends Controller
{
    /**
     * Menampilkan form input URL audit
     */
    public function form()
    {
        return view('audit');  // Pastikan form berada di resources/views/audit.blade.php
    }

    /**
     * Menganalisis URL dan menghasilkan hasil audit SEO
     */
    public function analyze(Request $request)
    {
        // Mengambil URL dari input form
        $url = $request->input('url');
        $saran = [];

        // Validasi URL
        if (!$url) {
            return back()->with('error', 'URL tidak ditemukan');
        }

        // Validasi format URL
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return back()->with('error', 'URL tidak valid. Pastikan format URL lengkap dan benar.');
        }

        try {
            // Mengambil data dari URL menggunakan Http client Laravel
            $response = Http::get($url);
        } catch (\Exception $e) {
            // Menangani error jika URL tidak dapat diakses
            return back()->with('error', 'Gagal mengakses URL. Periksa kembali alamatnya.');
        }

        // Menyaring HTML menggunakan DomCrawler
        $html = $response->body();
        $crawler = new Crawler($html);

        // ✅ Title Tag
        $title = $crawler->filter('title')->count() ? $crawler->filter('title')->text() : 'Tidak ditemukan';
        if ($title === 'Tidak ditemukan') {
            $saran[] = 'Halaman tidak memiliki <code>&lt;title&gt;</code>. Tambahkan untuk SEO yang lebih baik.';
        }

        // ✅ Meta Description
        $description = 'Tidak ditemukan';
        $metaTags = $crawler->filter('meta[name="description"]');
        if ($metaTags->count()) {
            $description = $metaTags->first()->attr('content');
        } else {
            $saran[] = 'Meta description belum ditambahkan. Ini penting untuk cuplikan di hasil pencarian.';
        }

        // ✅ Heading H1
        $h1 = $crawler->filter('h1')->count() ? $crawler->filter('h1')->first()->text() : 'Tidak ditemukan';
        if ($h1 === 'Tidak ditemukan') {
            $saran[] = 'Tidak ditemukan <code>&lt;h1&gt;</code>. Pastikan setiap halaman punya heading utama.';
        }

        // ✅ Alt Text pada Gambar
        $imgTags = $crawler->filter('img');
        $imgCount = $imgTags->count();
        $imgWithAlt = $imgTags->reduce(fn ($node) => $node->attr('alt') !== null && trim($node->attr('alt')) !== '')->count();
        $altRatio = $imgCount > 0 ? round(($imgWithAlt / $imgCount) * 100) : 100;
        if ($altRatio < 100) {
            $saran[] = "Sebagian gambar tidak memiliki <code>alt text</code>. Ini penting untuk aksesibilitas dan SEO.";
        }

        // ✅ Struktur URL
        $parsedUrl = parse_url($url);
        $path = $parsedUrl['path'] ?? '';
        if (strlen($path) > 60 || preg_match('/[^a-zA-Z0-9\-\/]/', $path)) {
            $saran[] = "Struktur URL tidak optimal. Gunakan URL pendek, jelas, dan mengandung kata kunci.";
        }

        // ✅ Keyword Density
        $contentText = strtolower($crawler->filter('body')->text());
        $mainKeyword = 'umkm';
        $keywordCount = substr_count($contentText, $mainKeyword);
        $totalWords = str_word_count($contentText);
        $density = $totalWords > 0 ? round(($keywordCount / $totalWords) * 100, 2) : 0;
        if ($density < 0.5 || $density > 5) {
            $saran[] = "Kepadatan kata kunci '<b>$mainKeyword</b>' adalah <b>$density%</b>. Idealnya 1%–3%.";
        }

        // ✅ PageSpeed & Mobile Friendly
        $pagespeedScore = 'Tidak tersedia';
        $mobileFriendly = true;

        try {
            $apiResponse = Http::get("https://www.googleapis.com/pagespeedonline/v5/runPagespeed", [
                'url' => $url,
                'key' => env('PAGESPEED_API_KEY'),
                'strategy' => 'mobile',
            ]);

            if ($apiResponse->successful()) {
                $lighthouse = $apiResponse->json()['lighthouseResult'];
                $pagespeedScore = $lighthouse['categories']['performance']['score'] * 100;

                if ($pagespeedScore < 80) {
                    $saran[] = "Skor performa Google PageSpeed rendah: <b>$pagespeedScore</b>. Optimalkan kecepatan situs.";
                }

                $viewportScore = $lighthouse['audits']['viewport']['score'] ?? 1;
                if ($viewportScore < 1) {
                    $mobileFriendly = false;
                    $saran[] = "Situs tidak responsif. Pastikan tampilan mendukung perangkat mobile.";
                }
            } else {
                $saran[] = "Gagal mengambil data kecepatan situs dari Google PageSpeed API.";
            }
        } catch (\Exception $e) {
            $saran[] = "Terjadi kesalahan saat menghubungi PageSpeed API.";
        }

        // ✅ Skoring
        $score = 0;
        $score += $title !== 'Tidak ditemukan' ? 30 : 0;
        $score += $description !== 'Tidak ditemukan' ? 20 : 0;
        $score += $h1 !== 'Tidak ditemukan' ? 20 : 0;
        $score += $altRatio === 100 ? 10 : 0;
        $score += (!str_contains($path, '?') && strlen($path) <= 60) ? 5 : 0;
        $score += $pagespeedScore !== 'Tidak tersedia' && $pagespeedScore >= 80 ? 10 : 0;
        $score += $mobileFriendly ? 5 : 0;

        $chartData = [
            'Title Tag' => $title !== 'Tidak ditemukan' ? 30 : 0,
            'Meta Description' => $description !== 'Tidak ditemukan' ? 20 : 0,
            'Heading H1' => $h1 !== 'Tidak ditemukan' ? 20 : 0,
            'Alt Text' => $altRatio === 100 ? 10 : 0,
            'Struktur URL' => (!str_contains($path, '?') && strlen($path) <= 60) ? 5 : 0,
            'PageSpeed' => $pagespeedScore !== 'Tidak tersedia' && $pagespeedScore >= 80 ? 10 : 0,
            'Mobile Friendly' => $mobileFriendly ? 5 : 0,
        ];

        $result = [
            'url' => $url,
            'title' => $title,
            'description' => $description,
            'h1' => $h1,
            'alt_text_score' => "$altRatio%",
            'keyword_density' => "$density%",
            'pagespeed_score' => $pagespeedScore,
            'score' => $score,
            'saran' => $saran,
            'chartData' => $chartData
        ];

        // Menyimpan Riwayat Audit
        AuditHistory::create([
            'user_id' => auth()->id(),
            'url' => $url,  // Pastikan kolom `url` diisi
            'seo_score' => $score,  // Pastikan kolom `seo_score` diisi
        ]);

        // Mengembalikan hasil audit ke tampilan
        return view('audit-result', compact('result'));
    }
}
