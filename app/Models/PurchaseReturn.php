<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'purchase_date',
        'reference',
        'shipping',
        'status',
        'notes',
        'sub_total'
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


    public function product(){
        return $this->belongsTo(product::class,'product_id','id');
    }

    public function purchase(){
        return $this->belongsTo(Purchase::class,'purcheseID','id');
    }


}
