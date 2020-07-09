<?php

namespace Modules\User\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\User\Http\Requests\RoleCreateRequest;
use Modules\User\Http\Requests\UserCreateRequest;
use Modules\User\Repositories\RoleRepository;
use Modules\User\Repositories\UserRepository;

class RoleController extends BaseController
{
	/**
	 * @var UserRepository
	 */
	private $repository;
	
	public function __construct(RoleRepository $repository) {
		$this->repository = $repository;
	}
	
	/**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
	    $roles = $this->repository->all();
    	
        return $roles;
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(RoleCreateRequest $request)
    {
    	$user = $this->repository->create($request);
	
	    return $this->response->created('/roles/' . $user->id, $user);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return $this->repository->get($id);
    }
    
    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
	    return $this->repository->delete($id);
    }
}
