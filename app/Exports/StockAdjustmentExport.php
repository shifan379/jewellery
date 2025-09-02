<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockAdjustmentExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    public function collection()
    {
        return $this->products->map(function ($product) {
            return [
                'Location' => $product->locationRelation->name  ?? 'N/A',
                'Supplier' => $product->supply->name ?? 'N/A',
                'Product' => $product->product_name,
                'Category' => $product->cate->category ?? 'N/A',
                'Date' => $product->created_at->format('d M Y'),
                'Quantity' => $product->quantity,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Location',
            'Supplier',
            'Product',
            'Category',
            'Date',
            'Quantity',
        ];
    }
}
