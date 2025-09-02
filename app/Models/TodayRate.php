<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TodayRate extends Model
{
    //

    protected $fillable = [
        'categoryID',
        'rate',
        'userID'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class,'categoryID','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'userID','id');
    }
}
