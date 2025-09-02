<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerSheet extends Model
{
    //
    protected $fillable = [
        'customerID',
        'orderId',
        'amount',
        'type',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerID', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'orderId', 'id');
    }

}
