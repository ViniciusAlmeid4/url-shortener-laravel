<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortUrl extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id',
        'original',
        'code',
        'clicks',
        'password_hash',
        'expires_at',
        'is_active'
    ];

    protected $casts = [
        'clicks' => 'integer',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function getShortenedAttribute(): String {
        $base = config('app.url');
        return rtrim($base) . '/shorten/' . $this->code;
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
