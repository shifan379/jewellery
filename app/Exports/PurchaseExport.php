<?php

namespace App\Exports;

use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PurchaseExport implements FromCollection, WithHeadings, WithMapping
{
    // protected $purchaseId;

    // public function __construct($purchaseId)
    // {
    //     $this->purchaseId = $purchaseId;
    // }

    // public function collection()
    // {
    //     return Purchase::with('supplier', 'items.product')
    //         ->where('id', $this->purchaseId)
    //         ->get();
    // }

    // public function headings(): array
    // {
    //     return [
    //         'Purchase ID',
    //         'Supplier',
    //         'Purchase Date',
    //         'Reference',
    //         'Product Name',
    //         'Qty',
    //         'Purchase Price',
    //         'Discount',
    //         'Unit Cost',
    //         'Total',
    //     ];
    // }

    // public function map($purchase): array
    // {
    //     $rows = [];

    //     // flatten purchase items into rows
    //     if ($purchase->items->isEmpty()) {
    //         return [
    //             $purchase->id,
    //             $purchase->supplier->company_name ?? '',
    //             $purchase->purchase_date,
    //             $purchase->reference,
    //             '',
    //             '',
    //             '',
    //             '',
    //             '',
    //             '',
    //         ];
    //     }

    //     $rows = [];
    //     foreach ($purchase->items as $item) {
    //         $rows[] = [
    //             $purchase->id,
    //             $purchase->supplier->company_name ?? '',
    //             $purchase->purchase_date,
    //             $purchase->reference,
    //             $item->product->product_name ?? '',
    //             $item->qty,
    //             $item->purchase_price,
    //             $item->discount,
    //             $item->purchase_price - $item->discount,
    //             ($item->purchase_price - $item->discount) * $item->qty,
    //         ];
    //     }

    //     return $rows;
    // }
    protected $ids;

    public function __construct(array $ids)
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        return Purchase::with('supplier', 'items.product')->whereIn('id', $this->ids)->get();
    }

    public function headings(): array
    {
        return [
            'Purchase ID',
            'Supplier',
            'Purchase Date',
            'Reference',
            'Product Name',
            'Qty',
            'Purchase Price',
            'Discount',
            'Unit Cost',
            'Total',
        ];
    }

    public function map($purchase): array
    {
        $rows = [];

        if ($purchase->items->isEmpty()) {
            return [
                $purchase->id,
                $purchase->supplier->company_name ?? '',
                $purchase->purchase_date,
                $purchase->reference,
                '',
                '',
                '',
                '',
                '',
                '',
            ];
        }

        $rows = [];
        foreach ($purchase->items as $item) {
            $rows[] = [
                $purchase->id,
                $purchase->supplier->company_name ?? '',
                $purchase->purchase_date,
                $purchase->reference,
                $item->product->product_name ?? '',
                $item->qty,
                $item->purchase_price,
                $item->discount,
                $item->purchase_price - $item->discount,
                ($item->purchase_price - $item->discount) * $item->qty,
            ];
        }

        return $rows;
    }
}
