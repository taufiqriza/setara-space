<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\MerchantIntegration;

class MerchantOrder extends Model
{
    protected $fillable = ['order_id', 'integration_id', 'external_order_id', 'driver_name', 'driver_phone', 'driver_plate', 'booking_id', 'raw_payload'];
    
    protected $casts = [
        'raw_payload' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    public function integration()
    {
        return $this->belongsTo(MerchantIntegration::class, 'integration_id');
    }
}
