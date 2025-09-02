<?php

namespace App\Exports;

use App\Models\PurchaseReturn;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchaseReturnExport implements FromCollection, WithHeadings
{
    protected $ids;

    public function __construct($ids)
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        return PurchaseReturn::with('product','purchase')
        ->whereIn('id', $this->ids)
        ->get()
        ->map(function ($item) {
            return [
                'purchase_date' => $item->purchase_date,
                'purchase_code' => optional($item->purchase)->purchase_code,
                'product_name' => optional($item->product)->product_name,
                'purcheseID' => $item->purcheseID,
                'qty' => $item->qty,
                'purchase_price' => $item->purchase_price,
                'discount' => $item->discount,
                'unit_cost' => $item->unit_cost,
                'total' => $item->total,
                'return_total' => $item->return_total,
                'notes' => $item->notes,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Purchase Date',
            'Purchase Code',
            'Product Name',
            'Purchase ID',
            'Quantity',
            'Purchase Price',
            'Discount',
            'Unit Cost',
            'Total',
            'Return Total',
            'Notes',
        ];
    }
}
