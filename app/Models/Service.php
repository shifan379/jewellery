<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //
    protected $table = 'product_service_offers';

    protected $fillable = [
        'product_id',
        'free_service_count',
        'validity_days',
    ];
}
