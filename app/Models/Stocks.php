<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    //
    protected $fillable = [
        'product_id',
        'stock',
        'location_id',
    ];

    public function product()
    {
        return $this->belongsTo(product::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

//     public function latestTransfer()
// {
//     return $this->hasOne(StockTransfer::class, 'product_id', 'product_id')
//         ->whereColumn('stock_transfers.to_location_id', 'stocks.location_id')
//         ->latestOfMany();
// }

}
