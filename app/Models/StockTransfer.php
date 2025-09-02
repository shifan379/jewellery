<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransfer extends Model
{
    //
    protected $fillable = [
        'product_id',
        'from_location_id',
        'to_location_id',
        'stock_quantity',
        'responsible_person',
        'ref_number',
        'notes',
    ];
    public function product()
    {
        return $this->belongsTo('App\Models\product', 'product_id');
    }
    // public function stock()
    // {
    //     return $this->belongsTo('App\Models\Location', 'from_location_id');
    // }
    // public function toStock()
    // {
    //     return $this->belongsTo('App\Models\Location', 'to_location_id');

    // }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function fromLocation()
    {
        return $this->belongsTo(Location::class, 'from_location_id');
    }

    public function toLocation()
    {
        return $this->belongsTo(Location::class, 'to_location_id');
    }

}
