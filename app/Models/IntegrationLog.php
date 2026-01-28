<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntegrationLog extends Model
{
    protected $fillable = ['integration_id', 'type', 'endpoint', 'status_code', 'request_payload', 'response_body', 'error_message', 'ip_address'];
    
    // Do not cast payload to array automatically if it might be huge text or malformed json. 
    // But usually acceptable. Let's keep it as text in DB but maybe accessor if needed.
    // Actually, let's cast if we want easy access.
    
    // protected $casts = [
    //    'request_payload' => 'array',
    //    'response_body' => 'array'
    // ];

    public function integration()
    {
        return $this->belongsTo(MerchantIntegration::class, 'integration_id');
    }
}
