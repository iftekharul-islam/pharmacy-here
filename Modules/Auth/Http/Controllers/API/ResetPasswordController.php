<?php

namespace Modules\Auth\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Dingo\Api\Exception\UpdateResourceFailedException;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Modules\Auth\Http\Requests\PasswordResetValidationRequest;
use Modules\Auth\Repositories\ResetPasswordRepository;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    private $repository;

    public function __construct(ResetPasswordRepository $resetPasswordRespository)
    {
        $this->repository = $resetPasswordRespository;
    }

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * @param PasswordResetValidationRequest $request
     * @return void
     */
    public function reset(PasswordResetValidationRequest $request)
    {
        $userInfo = $this->repository->getUserInfo($request);

        $lifetime = config('auth.password.lifetime');

        if ( Carbon::parse($userInfo->created_at)->addSeconds($lifetime)->isPast()) {
            throw new UnauthorizedHttpException('','Invalid Token');
        }

        if ($userInfo->token != $request->token) {
            throw new UnauthorizedHttpException('','Invalid token');
        }

        $this->repository->resetNewPassword($userInfo->email, $request->password);

    }

}
