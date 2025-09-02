<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    //
    protected $casts = [
        'values' => 'array',
    ];
    protected $fillable = [
        'name',
        'values',
        'status',
    ];
}
