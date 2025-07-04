<?php

// app/Models/Audit.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    protected $casts = [
        'issues' => 'array',
    ];
}
