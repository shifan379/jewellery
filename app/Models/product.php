<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    //

    protected $fillable = [
        'item_code',
        'prefix',
        'product_name',
        'weight',
        'category',
        'sub_category',
        'mark',
        'wholesale_price',
        'specialist',
        'quantity',
        'buying_price',
        'images',
        'location',
        'unit',
        'product_type',
        'supplier_id',
    ];


    public function cate()
    {
        return $this->belongsTo(Category::class, 'category', '', 'id');
    }

    public function supply()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function stock()
    {
        return $this->hasOne(Stocks::class);
    }

    // location relation, foreign key 'location' column
    public function locationRelation()
    {
        return $this->belongsTo(Location::class, 'location', 'id');
    }

    public function warranty_item(){
        return $this->belongsTo(Warranty::class,'warranty','id');
    }

    public function rate(){
        return $this->belongsTo(TodayRate::class,'category','categoryID');
    }


}
