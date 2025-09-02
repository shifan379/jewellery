<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarcodeSetting extends Model
{
    //
    protected $fillable = [
        "label_name","fields","barcode_width","barcode_hight","font_size","label_width","label_hight",
        "lable_count_row",'font_family'
    ] ;
}
