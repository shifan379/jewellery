<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //

     protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'address','city','province','image', 'status',
        'purchase_count','purchase_total_value','loyalty_points','customer_nic',
    ];


    public function summer(){
        return $this->hasMany(CustomerSheet::class,'CustomerID','id');
    }
}
