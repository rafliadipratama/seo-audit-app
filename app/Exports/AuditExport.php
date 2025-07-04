<?php

namespace App\Exports;

use App\Models\AuditHistory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AuditExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Mengambil semua data audit
     */
    public function collection()
    {
        return AuditHistory::with('user')->get();
    }

    /**
     * Menentukan header kolom di Excel
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama User',
            'URL',
            'Skor SEO',
            'Tanggal Audit',
        ];
    }

    /**
     * Menentukan isi tiap baris (mapping)
     */
    public function map($audit): array
    {
        return [
            $audit->id,
            $audit->user->name ?? 'Tidak Diketahui',
            $audit->url,
            $audit->seo_score,
            $audit->created_at->format('Y-m-d H:i'),
        ];
    }
}
