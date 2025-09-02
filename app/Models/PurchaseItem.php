<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    //
    protected $table = 'purchase_items'; // make sure table name is correct

    protected $fillable = [
        'purchase_id', 'product_id', 'qty',
        'purchase_price', 'discount', 'unit_cost', 'total','weight','item_code'
    ];

    public function product()
    {
        return $this->belongsTo(product::class,'product_id','id');
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

}
