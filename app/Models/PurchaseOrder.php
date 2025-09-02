<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    //
    protected $table = 'purchase_items';

    protected $fillable = [
        'purchase_id',
        'product_id',
        'qty',
        'purchase_price',
        // add more fields if needed
    ];

    public function product()
    {
        return $this->belongsTo(product::class, 'product_id');
    }
}
