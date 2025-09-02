<?php

namespace App\Exports;

use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FilteredPurchaesExport implements FromCollection, WithHeadings
{
    protected $supplierId, $startDate, $endDate;

    public function __construct($supplierId, $startDate, $endDate)
    {
        $this->supplierId = $supplierId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //
        $data = collect(); // Empty collection to hold rows

        if ($this->supplierId == 'all') {
            $purchases = Purchase::with(['supplier', 'items'])

                ->whereBetween('created_at', [$this->startDate, $this->endDate])
                ->latest()
                ->get();

            foreach ($purchases as $purchase) {
                foreach ($purchase->items as $item) {
                    $data->push([
                        'purchase_code' => $purchase->purchase_code ?? 'N/A',
                        'reference' => $purchase->reference ?? 'N/A',
                        'supplier' => $purchase->supplier->company_name ?? 'N/A',
                        'date' => $item->created_at->format('Y-m-d H:i'),
                        'product' => $item->product->product_name,
                        'category' => $item->product->cate->category ?? 'N/A',
                        'instock_qty' => $item->product->quantity ?? 0,
                        'purchase_qty' => $item->qty ?? 0,
                        'purchase_Amount' => $item->purchase_price,
                    ]);
                }
            }
        } else {
            $purchases = Purchase::with(['supplier', 'items'])
                ->where('supplier_id', $this->supplierId)
                ->whereBetween('created_at', [$this->startDate, $this->endDate])
                ->latest()
                ->get();

            foreach ($purchases as $purchase) {
                foreach ($purchase->items as $item) {
                    $data->push([
                        'purchase_code' => $purchase->purchase_code ?? 'N/A',
                        'reference' => $purchase->reference ?? 'N/A',
                        'supplier' => $purchase->supplier->company_name ?? 'N/A',
                        'date' => $item->created_at->format('Y-m-d H:i'),
                        'product' => $item->product->product_name,
                        'category' => $item->product->cate->category ?? 'N/A',
                        'instock_qty' => $item->product->quantity ?? 0,
                        'purchase_qty' => $item->qty ?? 0,
                        'purchase_Amount' => $item->purchase_price,
                    ]);
                }
            }
        }


        return $data;
    }

    public function headings(): array
    {
        return [
            'Purchase Code',
            'Reference',
            'Supplier',
            'Date',
            'Product Name',
            'Category',
            'Instock Qty',
            'Purchase Qty',
            'Purchase Amount',
        ];
    }
}
