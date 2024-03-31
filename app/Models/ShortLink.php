<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortLink extends Model
{
    use HasFactory;
    protected $fillable = [
        'original_link', 'short_link', 'max_visits', 'visits', 'expires_at',
    ];
}
