<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class PermissionSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
	
	    $permissions = [
		    'create.user',
		    'edit.user',
		    'delete.user',
		    'view.user',
		
		    'create.product',
		    'edit.product',
		    'delete.product',
		    'view.product',
		
		    'create.role',
		    'edit.role',
		    'delete.role',
		    'view.role',
	    ];
	
	    foreach ($permissions as $permission) {
		    Permission::create([ 'name' => $permission]);
	    }
	
	    $this->command->info(count($permissions) . " Permissions Created.");
    }
}
