<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'invoice_no',
        'customer_id',
        'phone_number',
        'subtotal',
        'discount',
        'total',
        'cashier_id',
        'sales_type',
        'discount_type',
        'return_amount',
        'order_type',
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'id', 'orderID');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'orderID', 'id');
    }

    public function return_data(){
        return $this->hasMany(ReturnLog::class,'orderID','id');
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id', 'id');
    }
}
