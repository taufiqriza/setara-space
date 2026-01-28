<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'order_number',
        'customer_name',
        'table_id',
        'user_id',
        'order_type',
        'status',
        'subtotal',
        'tax_rate',
        'tax_amount',
        'discount_amount',
        'promo_code',
        'total',
        'payment_method',
        'payment_status',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function markAsOnKitchen(): void
    {
        $this->update(['status' => 'on_kitchen']);
    }

    public function markAsDone(): void
    {
        $this->update(['status' => 'all_done']);
    }

    public function markAsServed(): void
    {
        $this->update(['status' => 'to_be_served']);
    }

    public function markAsCompleted(): void
    {
        $this->update(['status' => 'completed']);
        
        // Release table if dine in
        if ($this->table_id) {
            $this->table->markAsAvailable();
        }
    }
}
