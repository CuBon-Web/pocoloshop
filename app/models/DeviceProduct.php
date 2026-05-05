<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class DeviceProduct extends Model
{
    protected $table = "device_products";
    
    protected $fillable = [
        'device_id',
        'product_code',
        'product_serial',
        'warranty_date',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'warranty_date' => 'datetime',
    ];
}
