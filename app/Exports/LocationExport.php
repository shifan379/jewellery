<?php

namespace App\Exports;

use App\Models\Location;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class LocationExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $locations;

    protected $ids;
    public function __construct($ids)
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        return Location::select('id', 'name', 'contact_person', 'phone', 'product_count', 'status',)->get();

        // return Supplier::all();
    }
      public function headings(): array
    {
        return ['ID', 'Location Name', 'Contact Person', 'Phone', 'Product Count', 'Status',];
    }

}
