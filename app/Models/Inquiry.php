<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference', 'type', 'name', 'email', 'phone', 'company', 'payload',
        'document_path', 'status',
    ];

    protected function casts(): array
    {
        return ['payload' => 'array'];
    }
}
