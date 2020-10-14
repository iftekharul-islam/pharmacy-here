<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\User\Entities\Models\User;
use Modules\User\Repositories\CustomerRepository;
use Modules\User\Repositories\UserRepository;

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
//    	return $data;
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
        $data = $this->repository->findById($id);
        return view('user::customer.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = $this->repository->findById($id);
        return view('user::customer.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return false;
        }

        $data = $request->only(['name', 'email', 'phone_number']);

        if (isset($request->name)) {
            $user->name = $request->name;
        }

        if (isset($data['email'])) {
            $user->email = $data['email'];
        }

        if (isset($data['phone_number'])) {
            $user->phone_number = $data['phone_number'];
        }
        $user->save();

//           $data = $this->repository->updateWeb($id, $request);
//           if ($data == false){
//                return redirect()->route('customer.index')->with('failed', 'Customer not updated');
//           }
        return redirect()->route('customer.index')->with('success', 'Customer successfully updated');
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
