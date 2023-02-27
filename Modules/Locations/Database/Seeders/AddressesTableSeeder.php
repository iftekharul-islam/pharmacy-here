<?php

namespace Modules\Locations\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Locations\Entities\Models\Address;

class AddressesTableSeeder extends Seeder
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

        Address::create([
            'user_id' => 1,
            'address' => '950/A, Road: 11, Avenue 2',
            'area_id' => 1
        ]);
        Address::create([
            'user_id' => 2,
            'address' => '800/A, Road: 10, Avenue 2',
            'area_id' => 1
        ]);
        Address::create([
            'user_id' => 3,
            'address' => '700/A, Road: 8, Avenue 2',
            'area_id' => 1
        ]);
        Address::create([
            'user_id' => 4,
            'address' => '750/A, Road: 8, Avenue 2',
            'area_id' => 1
        ]);
    }
}
