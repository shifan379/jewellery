<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
  protected $fillable = [
        'company_name', 'email', 'phone', 'address', 'bank_name', 'bank_acc_no', 'status', 'image',
    ];
}
