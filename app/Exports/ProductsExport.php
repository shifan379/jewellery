<?php

namespace App\Exports;

use App\Models\product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class ProductsExport implements FromCollection, WithHeadings
{

    protected $ids;
    public function __construct($ids)
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        return product::whereIn('id', $this->ids)
            ->select('mark', 'product_name', 'buying_price','weight', 'unit', 'quantity')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Item Code',
            'Product Name',
            'Buying Price',
            'Weight',
            'Unit',
            'Quantity',
        ];
    }
}
