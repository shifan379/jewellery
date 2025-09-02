<?php

namespace App\Exports;

use App\Models\StockTransfer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockTransferExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public $selectedIds;

    public function __construct($selectedIds = null)
    {
        $this->selectedIds = $selectedIds;
    }

    public function collection()
    {
        return StockTransfer::with(['product', 'fromLocation', 'toLocation'])
            ->whereIn('id', $this->selectedIds)
            ->get()
            ->map(function ($transfer) {
                return [
                    'From' => $transfer->fromLocation->name ?? '',
                    'To' => $transfer->toLocation->name ?? '',
                    'Product' => $transfer->product->product_name ?? '',
                    'Quantity' => $transfer->stock_quantity,
                    'Responsible Person'=> $transfer->responsible_person,
                    'Ref Number' => $transfer->ref_number,
                    'Date' => $transfer->created_at->format('d-m-Y'),
                ];
            });

    }

    public function headings(): array
    {
        return ['From', 'To', 'Product', 'Quantity','Responsible Person', 'Ref Number', 'Date'];
    }
}
