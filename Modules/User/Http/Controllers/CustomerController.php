<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\User\Repositories\CustomerRepository;
use Modules\User\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
	/**
	 * @var UserRepository
	 */
	private $repository;

	public function __construct(CustomerRepository $repository) {
		$this->repository = $repository;
	}

	/**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
    	$data = $this->repository->all();

        // return view('user::index', compact('users'));
        return view('user::customer.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('user::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('user::edit');
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
        $users = $this->repository->delete($id);
        return redirect()->route('customer.index')->with('success', 'Customer deletion successfully');
    }
}
