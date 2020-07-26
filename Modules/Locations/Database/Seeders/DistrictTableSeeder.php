<?php

namespace Modules\Locations\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Locations\Entities\Models\District;

class DistrictTableSeeder extends Seeder
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
        District::create([
            'name' => 'Dhaka',
            'bn_name' => 'ঢাকা',
            'slug' => Str::slug('Dhaka'),
            'division_id' => 1
        ]);
    }
}
