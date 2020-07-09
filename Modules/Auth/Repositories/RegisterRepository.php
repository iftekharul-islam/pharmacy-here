<?php


namespace Modules\Auth\Repositories;


use App\User;

class RegisterRepository
{
    /**
     * @param $request
     * @return mixed
     */
    public function createUser($request)
    {
        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
    }

}
