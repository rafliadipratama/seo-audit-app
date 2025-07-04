<?php

namespace App\Exports;

use App\Models\AuditHistory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserAuditExport implements FromCollection, WithHeadings, WithMapping
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function collection()
    {
        return AuditHistory::where('user_id', $this->userId)->get();
    }

    public function headings(): array
    {
        return ['ID', 'URL', 'Skor SEO', 'Tanggal Audit'];
    }

    public function map($audit): array
    {
        return [
            $audit->id,
            $audit->url,
            $audit->seo_score,
            $audit->created_at->format('Y-m-d H:i'),
        ];
    }
}
