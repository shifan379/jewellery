<?php

namespace App\Exports;

use App\Models\PurchaseItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchaseItemsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return PurchaseItem::with('product')->get()->map(function ($item) {
            return [
                'Product Name' => $item->product->product_name ?? 'N/A',
                'Purchased Amount' => $item->purchase_price * $item->qty,
                'Purchased QTY' => $item->qty,
                'Instock QTY' => $item->product->quantity ?? 0,
            ];
        });
    }

    public function headings(): array
    {
        return ['Product Name', 'Purchased Amount', 'Purchased QTY', 'Instock QTY'];
    }
}
