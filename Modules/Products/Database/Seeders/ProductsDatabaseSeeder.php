<?php

namespace Modules\Products\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ProductsDatabaseSeeder extends Seeder
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
         $this->call(CompanySeederTableSeeder::class);
         $this->call(GenericTableSeeder::class);
         $this->call(FormTableSeeder::class);
         $this->call(ProductTableSeeder::class);
    }
}
