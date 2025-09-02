<?php

namespace App\Exports;

use App\Models\Customer;
use FontLib\TrueType\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class CustomersExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */


    protected $customers;

    // public function __construct(Collection $customers)
    // {
    //     $this->customers = $customers;
    // }
     protected $ids;
    public function __construct($ids)
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        // return $this->customers->map(function ($customer) {
        //     return [
        //         'First Name' => $customer->first_name,
        //         'Last Name'  => $customer->last_name,
        //         'Email'      => $customer->email,
        //         'Phone'      => $customer->phone,
        //         'Address'    => $customer->address,
        //         'City'       => $customer->city,
        //         'Province'      => $customer->province,
        //         // 'Phone'      => $customer->phone,
        //     ];
        // });
        return Customer::whereIn('id', $this->ids)
            ->select('first_name', 'last_name', 'email', 'phone', 'address', 'city', 'province')
            ->get();

    }

    public function headings(): array
    {
        return [
            'First Name',
            'Last Name',
            'Email',
            'Phone',
            'Address',
            'City',
            'Province',
        ];
    }
}
