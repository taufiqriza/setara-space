<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MerchantIntegration;

class MerchantCredential extends Model
{
    protected $fillable = ['integration_id', 'client_id', 'client_secret', 'relay_secret', 'access_token', 'token_expiry'];
    
    protected $casts = [
        'client_secret' => 'encrypted',
        'relay_secret' => 'encrypted',
        'access_token' => 'encrypted',
        'token_expiry' => 'datetime',
    ];

    public function integration()
    {
        return $this->belongsTo(MerchantIntegration::class, 'integration_id');
    }
}
