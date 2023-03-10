<?php

namespace Modules\Locations\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class LocationsDatabaseSeeder extends Seeder
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
        $this->call(DivisionTableSeeder::class);
        $this->call(DistrictTableSeeder::class);
        $this->call(ThanaTableSeeder::class);
        $this->call(AreaTableSeeder::class);
        $this->call(AddressesTableSeeder::class);
    }
}
