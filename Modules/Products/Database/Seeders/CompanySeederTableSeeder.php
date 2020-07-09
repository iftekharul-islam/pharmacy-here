<?php

namespace Modules\Products\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
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
            'slug' => 'apollo-pharmaceutical-ltd',
            'status' => true
        ]);

        Company::create([
            'name' => 'ACI Limited',
            'slug' => 'aci-limited',
            'status' => true
        ]);

        Company::create([
            'name' => 'Beximco Pharmaceuticals Ltd',
            'slug' => 'beximco-pharmaceuticals-ltd',
            'status' => true
        ]);
    }
}
