<?php

namespace Modules\User\Repositories;


use Dingo\Api\Exception\DeleteResourceFailedException;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleRepository {

	
	public function all() {
		return Role::all();
	}
	
	/**
	 * @param $id
	 *
	 * @return mixed
	 */
	public function get($id) {
		return Role::findOrFail($id);
	}
	
	/**
	 * @param $request
	 *
	 * @return $this|\Illuminate\Database\Eloquent\Model
	 */
	public function create($request) {
		$role = $request->only('name');
		
		return Role::create($role);
	}
	
	/**
	 * @param $id
	 */
	public function delete($id) {
		$role = Role::find($id);
		
		if ($role) {
			$role->delete();
			return responseData('Resource has been deleted.');
		}
		
		throw new DeleteResourceFailedException("Resource not found.");
	}
	
	/**
	 * @param $id
	 */
	public function update(Request $request, $id) {
		$role = Role::findOrFail($id);
		$role->name = $request->name;
		$role->save();
		
		return responseData('Resource has been updated.');
	}
}
