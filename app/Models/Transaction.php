<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable = [
        'transaction_no', 'orderID', 'total', 'total_recived', 'change', 'payment_method','payment_status'
    ];


    public function order(){
        return $this->belongsTo(Order::class,'orderID','id');
    }

}
