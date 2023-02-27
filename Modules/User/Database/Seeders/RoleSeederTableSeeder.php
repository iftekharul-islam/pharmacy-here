<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class RoleSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $roles = [
            [
            	"name" => 'admin',
            ],
            [
	            "name" => 'accountant',
            ],
            [
	            "name" => 'pharmacy',
            ],
            [
	            "name" => 'customer',
            ]
        ];
        
        foreach ($roles as $role) {
	        Role::create($role);
        }
	
	    $this->command->info(count($roles) . " Roles Created.");
    }
}
