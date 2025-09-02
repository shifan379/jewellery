<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaltInvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Order::create([
            'invoice_no' => 'old',
            'subtotal' => '0.00',
            'discount' => '0.00',
            'total' => '0.00',
        ]);
        OrderItem::create([
            'orderID' => 1,
            'productID' => 1,
            'qty' => 1,
        ]);
        Transaction::create([
            'transaction_no' => 'old',
            'orderID' => 1,
        ]);
    }
}
