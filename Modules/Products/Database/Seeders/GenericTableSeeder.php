<?php

namespace Modules\Products\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Products\Entities\Model\Generic;

class GenericTableSeeder extends Seeder
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

        Generic::create([
            'name' => 'Alendronate tablet',
            'slug' => Str::slug('Alendronate tablet'),
            'status' => true
        ]);

        Generic::create([
            'name' => 'Benazepril HCTZ tablet',
            'slug' => Str::slug('Benazepril HCTZ tablet'),
            'status' => true
        ]);

        Generic::create([
            'name' => 'Calcitriol capsule',
            'slug' => Str::slug('Calcitriol capsule'),
            'status' => true
        ]);
    }
}
