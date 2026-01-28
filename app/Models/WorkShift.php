<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkShift extends Model
{
    protected $fillable = [
        'user_id',
        'start_time',
        'end_time',
        'start_cash',
        'end_cash_expected',
        'end_cash_actual',
        'start_photo',
        'end_photo',
        'status',
        'note',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'start_cash' => 'decimal:2',
        'end_cash_expected' => 'decimal:2',
        'end_cash_actual' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
