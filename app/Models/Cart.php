<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'discount_type',
        'discount',
        'net_price',
        'main_sub_total',
        'main_discount',
        'main_total',
        'return',
        'original_order_item_id',
        'main_return_amount',
        'sales_type',
        'act_rate',
        'weight',
    ];
    protected $casts = [
        'quantity' => 'decimal:2',
        'discount' => 'decimal:2',
        'net_price' => 'decimal:2',
        'main_sub_total' => 'decimal:2',
        'main_discount' => 'decimal:2',
        'main_total' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(product::class, 'product_id','id');
    }
}
