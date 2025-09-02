<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //
    protected $fillable = ['name', 'contact_person', 'phone', 'creat_by',];

    public function products()
    {
        return $this->hasMany(product::class, 'location', 'id'); // If you keep 'location' column in products table
    }
}
