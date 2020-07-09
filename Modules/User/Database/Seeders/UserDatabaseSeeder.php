<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Models\User;
use Spatie\Permission\Models\Role;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
	
	
	    $this->call(RoleSeederTableSeeder::class);
	    $this->call(PermissionSeederTableSeeder::class);
	    
        
	    $users = [
	    	[
	    		"name" => "Feroj Bepari",
			    "email" => "feroj@augnitive.com",
			    "password" => "12345678",
			    "role" => "admin"
		    ],
		    [
			    "name" => "Pharmacy",
			    "email" => "pharmacy@augnitive.com",
			    "password" => "12345678",
			    "role" => "pharmacy"
		    ],
		    [
			    "name" => "Accountant",
			    "email" => "accounts@augnitive.com",
			    "password" => "12345678",
			    "role" => "accountant"
		    ],
		    [
			    "name" => "Customer",
			    "email" => "customer@augnitive.com",
			    "password" => "12345678",
			    "role" => "customer"
		    ]
		    
	    ];
	    
	    foreach ($users as $user) {
	    	$role = Role::where('name', $user['role'])->first();
			unset($user['role']);
		
		    $u = User::create($user);
		    
	    	if ($role) {
			    $u->assignRole($role);
		    }
	    }
	
	    $this->command->info(count($users) . " User Created.");
    }
 }
