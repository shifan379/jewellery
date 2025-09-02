<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    //
     protected $fillable = [
        'orderID', 'productID', 'qty', 'net_price', 'discount', 'total','act_rate','weight',
    ];


    public function order(){
        return $this->belongsTo(Order::class,'orderID','id');
    }

    public function product(){
        return $this->belongsTo(product::class,'productID','id');
    }

}
