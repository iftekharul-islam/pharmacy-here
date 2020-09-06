<?php

namespace Modules\User\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Modules\User\Http\Requests\UserCreateRequest;
use Modules\User\Repositories\UserRepository;

class UserController extends BaseController
{
	/**
	 * @var UserRepository
	 */
	private $repository;

	public function __construct(UserRepository $repository) {
		$this->repository = $repository;
	}

	/**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
    	$users = $this->repository->all();

        return view('user::index', compact('users'));
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
    public function store(UserCreateRequest $request)
    {
    	$user = $this->repository->create($request);

	    return $this->response->created('/users/' . $user->id, $user);
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
        //
    }

    public function createOtp()
    {
        $user = Auth::user();
//        return $user->phone_number;

        $otp = $this->repository->createOtp($user->phone_number);

        return responseData('Otp creation successful');

    }

    public function verifyOtp(Request $request)
    {
        $user = Auth::user();
        $otpResponse = $this->repository->verifyOtp($request, $user->phone_number);

        if (! $otpResponse) {
            throw new StoreResourceFailedException('Failed to verify OTP');
        }

        return responseData('Otp verification successful');
    }
}
