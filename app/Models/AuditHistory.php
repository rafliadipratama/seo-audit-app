<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditHistory extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi melalui mass assignment
    protected $fillable = [
        'user_id',
        'url',
        'seo_score',
    ];

    // Menambahkan relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class); // Relasi belongsTo dengan User
    }
}

