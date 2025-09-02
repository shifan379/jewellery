<?php

namespace Database\Seeders;

use App\Models\product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaltProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        product::create([
            'location' => '1',
            'product_name' => 'Old Gold',
            'category' => '1',
            'prefix' => 'OG',
            'unit' => 'g',
            'mark' => 'OG0001',
            'item_code' => '0001',
            'quantity' => '1',
            'weight' => '0.00',
            'buying_price' => '0.00',
        ]);

    }
}
