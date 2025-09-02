<?php

namespace App\Exports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class SuppliersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

     protected $suppliers;

    protected $ids;
    public function __construct($ids)
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        return Supplier::select('id', 'company_name', 'email', 'phone', 'address', 'bank_name', 'bank_acc_no', 'status')->get();

        // return Supplier::all();
    }
      public function headings(): array
    {
        return ['ID', 'Company Name', 'Email', 'Phone', 'Address', 'Bank Name', 'Bank Acc No', 'Status'];
    }
}
