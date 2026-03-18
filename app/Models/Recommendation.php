<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recommendation extends Model
{
    protected $fillable = [
        'user_id',
        'plate_id',
        'score',
        'label',
        'warning_message',
        'status', 
    ];

    // Recommendation  User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Recommendation  Plat
    public function plat(): BelongsTo
    {
        return $this->belongsTo(Plat::class);
    }
}