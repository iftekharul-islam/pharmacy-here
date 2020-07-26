<?php

namespace Modules\Locations\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Locations\Entities\Models\Division;

class DivisionTableSeeder extends Seeder
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
        Division::create([
            'name' => 'Dhaka',
            'bn_name' => 'ঢাকা',
            'slug' => Str::slug('Dhaka'),
        ]);
    }
}
