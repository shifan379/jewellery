<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    //


    protected $fillable = [
        "name","status",'set',
    ] ;

    public function product_count()
    {
        return $this->hasMany(product::class, 'unit','name');
    }
}
