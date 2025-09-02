<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnLog extends Model
{
    //

    protected $fillable = ['user_id',
            'orderID',
            'orginal_order_id',
            'productID',
            'return_qty',
            'return_net_price',
            'total',
            'discount',
            'return_weight',
                    ];

    public function product_data(){
        return $this->belongsTo(product::class,'productID','id');
    }
}
