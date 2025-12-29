<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'is_active',
    ];

    public function configs()
    {
        return $this->hasMany(PaymentGatewayConfig::class, 'gateway_id');
    }

    public function getConfigValue($key, $default = null)
    {
        $config = $this->configs->where('key_name', $key)->first();

        return $config ? $config->key_value : $default;
    }
}
