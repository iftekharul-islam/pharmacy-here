<?php

namespace Modules\Products\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Products\Entities\Model\Product;
use Modules\Products\Entities\Model\ProductAdditionalInfo;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");

        $product = Product::create([
            'name' =>'Napa Paracetamol',
            'slug' => Str::slug('Napa Paracetamol'),
            'status' => true,
            'trading_price' => 40.40,
            'purchase_price' => 50.00,
            'unit' => 10,
            'is_saleable' => true,
            'conversion_factor' => 0.5,
            'type' => 'tablet',
            'form_id' => 1,
            'category_id' => 1,
            'generic_id' => 1,
            'manufacturing_company_id' => 1,
            'primary_unit_id' => 1,
        ]);
        ProductAdditionalInfo::create([
            'product_id' => $product->id,
        ]);

        $product2 = Product::create([
            'name' =>'Ace',
            'slug' => Str::slug('Ace'),
            'status' => true,
            'trading_price' => 40.40,
            'purchase_price' => 50.00,
            'unit' => 10,
            'is_saleable' => true,
            'conversion_factor' => 0.5,
            'type' => 'tablet',
            'form_id' => 1,
            'category_id' => 1,
            'generic_id' => 1,
            'manufacturing_company_id' => 1,
            'primary_unit_id' => 1,
        ]);
        ProductAdditionalInfo::create([
            'product_id' => $product2->id,
        ]);

        $product3 = Product::create([
            'name' =>'Napa Extra',
            'slug' => Str::slug('Napa extra'),
            'status' => true,
            'trading_price' => 40.40,
            'purchase_price' => 50.00,
            'unit' => 10,
            'is_saleable' => true,
            'conversion_factor' => 0.5,
            'type' => 'tablet',
            'form_id' => 1,
            'category_id' => 1,
            'generic_id' => 1,
            'manufacturing_company_id' => 1,
            'primary_unit_id' => 1,
        ]);
        ProductAdditionalInfo::create([
            'product_id' => $product3->id,
        ]);

    }
}
