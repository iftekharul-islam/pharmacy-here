<?php

namespace Modules\Products\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Products\Entities\Model\Company;

class CompanySeederTableSeeder extends Seeder
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
        Company::create([
            'name' => 'Apollo Pharmaceutical Ltd',
            'slug' => Str::slug('Apollo Pharmaceutical Ltd'),
            'status' => true
        ]);

        Company::create([
            'name' => 'ACI Limited',
            'slug' => Str::slug('ACI Limited'),
            'status' => true
        ]);

        Company::create([
            'name' => 'Beximco Pharmaceuticals Ltd',
            'slug' => Str::slug('Beximco Pharmaceuticals Ltd'),
            'status' => true
        ]);
    }
}
