<?php
namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesReportExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $data = collect(); // Empty collection to hold rows

        $orders = Order::with('items.product.cate')->latest()->get();

        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $data->push([
                    'invoice_no'     => optional($item->product)->item_code ?? 001 ,
                    'product_name'   => optional($item->product)->product_name ?? 'N/A',
                    'category'       => optional($item->product->cate)->category ?? 'N/A',
                    'sold_qty'       => $item->qty,
                    'net_price'      => number_format($item->net_price, 2),
                    'total_price'    => number_format($item->qty * $item->net_price, 2),
                    'date'           => $item->created_at->format('Y-m-d H:i'),
                    'instock_qty'    => optional($item->product)->quantity ?? 'N/A',
                ]);
            }
        }

        return $data;
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
