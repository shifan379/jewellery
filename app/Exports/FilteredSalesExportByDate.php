<?php
namespace App\Exports;

use App\Models\OrderItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FilteredSalesExportByDate implements FromCollection, WithHeadings
{
    protected  $startDate, $endDate;

    public function __construct( $startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return OrderItem::with('order')->with('product') // assuming relationship to orders
            ->whereHas('order', function ($q) {
                $q->whereBetween('created_at', [$this->startDate, $this->endDate]);
            })
            ->get()
            ->map(function ($item) {
                return [
                    'invoice_no'     => optional($item->product)->item_code ?? 001 ,
                    'product_name'   => optional($item->product)->product_name ?? 'N/A',
                    'category'       => optional($item->product->cate)->category ?? 'N/A',
                    'sold_qty'       => $item->qty,
                    'net_price'      => number_format($item->net_price, 2),
                    'total_price'    => number_format($item->qty * $item->net_price, 2),
                    'date'           => $item->created_at->format('Y-m-d H:i'),
                    'instock_qty'    => optional($item->product)->quantity ?? 'N/A',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Item No',
            'Product Name',
            'Category',
            'Sold Qty',
            'Net Price',
            'Total Price',
            'Date',
            'Instock Qty',
        ];
    }
}


