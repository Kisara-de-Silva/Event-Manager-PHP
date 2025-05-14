<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'user_id',
    ];

    protected $casts = [
        'event_date' => 'date', // Add this line to cast to Carbon instance
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
