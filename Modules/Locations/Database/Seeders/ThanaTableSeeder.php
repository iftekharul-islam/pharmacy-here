<?php

namespace Modules\Locations\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Locations\Entities\Models\Thana;

class ThanaTableSeeder extends Seeder
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
        Thana::create([
            'name' => 'Farmgate',
            'bn_name' => 'ফার্মগেট',
            'slug' => Str::slug('Farmgate'),
            'district_id' => 1
        ]);
    }
}
