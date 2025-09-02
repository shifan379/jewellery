<?php

namespace App\Http\Controllers\APP;

use App\Http\Controllers\Controller;
use App\Models\PurchaseItem;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use App\Exports\PurchaseItemsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;



class PurchaseOrderController extends Controller
{
    //
    public function index(Request $request)
    {
        // $orders = PurchaseOrder::all();
        $sort = $request->get('sort'); // From dropdown

        $query = PurchaseItem::with('product');

        switch ($sort) {
            case 'asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'desc':
                $query->orderBy('created_at', 'desc');
                break;
            case 'last_7_days':
                $query->where('created_at', '>=', now()->subDays(7));
                break;
            case 'last_month':
                $query->whereMonth('created_at', now()->subMonth()->month);
                break;
            case 'recent':
            default:
                $query->latest(); // recently added
                break;
        }

        $purchaseItems = $query->get();
        // $query = PurchaseItem::with('product')->get();

        return view("app.purchaseOrder.view", compact('purchaseItems'));
    }



    // PDF Export
    public function exportSelectedPdf(Request $request)
    {
        $ids = explode(',', $request->selected_ids);
        if (empty($ids) || count($ids) === 0 || (count($ids) === 1 && $ids[0] === '')) {
            return back()->with('error', 'Please select at least one purchase to export.');
        }

        $purchaseItems = PurchaseItem::with('product')->whereIn('id', $ids)->get();

        $pdf = Pdf::loadView('export.purchaseItem_pdf', compact('purchaseItems'));
        return $pdf->download('selected_purchase_items.pdf');
    }


    // Excel Export
    public function exportSelectedExcel(Request $request)
    {
        $ids = explode(',', $request->selected_ids);

        if (empty($ids) || count($ids) === 0 || (count($ids) === 1 && $ids[0] === '')) {
            return back()->with('error', 'Please select at least one purchase to export.');
        }

        $export = new class ($ids) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            protected $ids;
            public function __construct($ids)
            {
                $this->ids = $ids;
            }

            public function collection()
            {
                return PurchaseItem::with('product')
                    ->whereIn('id', $this->ids)
                    ->get()
                    ->map(function ($item) {
                        return [
                            'Product Name' => $item->product->product_name ?? '',
                            'Purchased Amount' => $item->purchase_price * $item->qty,
                            'Purchased QTY' => $item->qty,
                            'Instock QTY' => $item->product->stock_qty ?? 0,
                        ];
                    });
            }

            public function headings(): array
            {
                return ['Product Name', 'Purchased Amount', 'Purchased QTY', 'Instock QTY'];
            }
        };

        return Excel::download($export, 'selected_purchase_items.xlsx');
    }

}
