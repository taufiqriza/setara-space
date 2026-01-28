<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Merchant;
use App\Models\MerchantCredential;
use App\Models\MerchantOrder;

class MerchantIntegration extends Model
{
    protected $fillable = ['merchant_id', 'outlet_id', 'is_enabled', 'auto_accept', 'settings'];
    
    protected $casts = [
        'is_enabled' => 'boolean',
        'auto_accept' => 'boolean',
        'settings' => 'array',
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function credential()
    {
        return $this->hasOne(MerchantCredential::class, 'integration_id');
    }

    public function orders()
    {
        return $this->hasMany(MerchantOrder::class, 'integration_id');
    }
}
