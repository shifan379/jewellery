<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    //
    protected $fillable = [
        'supplier_id',
        'reference',
        'purchase_date',
        'purchase_code',
        'discount',
        'shipping',
        'total',
        'status',
        'notes'
    ];

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function purchase_items()
    {
        return $this->hasMany(PurchaseItem::class);
    }

}
