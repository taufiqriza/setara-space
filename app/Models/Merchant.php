<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    protected $fillable = ['slug', 'name', 'logo_url', 'status'];
    
    public function integrations()
    {
        return $this->hasMany(MerchantIntegration::class);
    }
}
