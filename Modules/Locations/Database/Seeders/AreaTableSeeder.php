<?php

namespace Modules\Locations\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Locations\Entities\Models\Area;

class AreaTableSeeder extends Seeder
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
        Area::create([
            'name' => 'Monipur Para',
            'bn_name' => 'মণিপুর পাড়া',
            'slug' => Str::slug('Monipur Para'),
            'thana_id' => 1
        ]);
    }
}
