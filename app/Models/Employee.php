<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;// Extend this

// class Employee extends Model
// {
//     //

// }

class Employee extends Authenticatable
{
    // Your model code
    use Notifiable;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'contact',
        'emp_code',
        'dob',
        'gender',
        'nationality',
        'joining_date',
        'shift',
        'department',
        'designation',
        'blood_group',
        'about',
        'address',
        'country',
        // 'state',
        'city',
        'zipcode',
        'emergency_name',
        'relationship',
        'emergency_contact_name1',
        'emergency_relationship1',
        'emergency_contact1',
        'emergency_contact_name2',
        'emergency_relationship2',
        'emergency_contact2',
        'bank_name',
        'branch',
        'account_no',
        'ifsc',
        'profile_photo',
        'password'
    ];
}
