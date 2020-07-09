<?php

namespace Modules\User\Repositories;


use Modules\User\Entities\Models\User;

class UserRepository {

	
	public function all() {
		return User::all();
	}
	
	public function get($id) {
	
	}
	
	public function create($request) {
		$user = $request->only('name', 'email', 'password');
		
		return User::create($user);
	}
	
	public function delete() {
		
	}
	
	public function update() {
		
	}
}
