<?php

namespace Modules\Auth\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Modules\Auth\Repositories\AuthRepository;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */


    use SendsPasswordResetEmails;

    private $repository;

    public function __construct(AuthRepository $auth_repository)
    {
        $this->repository = $auth_repository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $user = $this->repository->getUserByEmail($request->email);

        $token = JWTAuth::fromUser($user);

        return $this->repository->createPasswordResetData($user,$token);

    }

}
