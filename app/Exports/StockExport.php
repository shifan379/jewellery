<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $stocks;

    public function __construct($stocks)
    {
        $this->stocks = $stocks;
    }

    public function collection()
    {
        return $this->stocks->map(function ($stock) {
            return [
                'Product' => $stock->product->product_name ?? 'N/A',
                'Location' => $stock->location->name ?? 'N/A',
                // 'Date' => $stock->date->format('Y-m-d'),
                // 'Responsible Person' => $stock->responsible_person ?? 'N/A',
                'Quantity' => $stock->stock,
                'Last Updated' => $stock->updated_at->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return ['Product', 'Location', 'Quantity', 'Last Updated'];
    }
}
