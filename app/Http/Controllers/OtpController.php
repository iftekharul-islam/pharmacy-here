<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Http\Requests\PhoneValidationRequest;
use Modules\Auth\Repositories\AuthRepository;
use Modules\User\Entities\Models\User;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class OtpController extends Controller
{
    private $repository;

    public function __construct(AuthRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createOtp(PhoneValidationRequest $request)
    {
        $verifyNumber = $this->repository->checkPhoneNumber($request->phone_number);

        if (!$verifyNumber) {
//            throw new UnauthorizedHttpException('', 'Phone Number is not registered');
            $data = $this->repository->createCustomerWeb($request);

        }
        else {
            $otp = $this->repository->createOtpWeb($request);
            session()->put('phone_number', $request->phone_number);

            if (!$otp) {
                throw new StoreResourceFailedException('Failed to create OTP');
            }
        }
        return redirect()->route('customer.OTPForm');
    }



    public function verifyOTP(Request $request)
    {
        $otpResponse = $this->repository->verifyOtpWeb($request);

        if ($otpResponse == true) {
            $user = User::where('phone_number', session()->get('phone_number'))->first();

            if ($user->name != null) {
                \Auth::login($user);
                session()->forget('phone_number');

                if ($request->session()->has('cart')) {

                    $datas = session()->get('cart');

                    foreach ($datas as $id => $data) {
//                        print_r($data['amount']);
                        Cart::create([
                            'product_id' => $id,
                            'customer_id' => auth()->user()->id,
                            'amount' => $data['amount'],
                            'quantity' => $data['quantity'],
                        ]);

                    }

                    session()->forget('cart');

                    return redirect()->route('cart.index');
                }
                return redirect()->route('product-list');
            }
            return redirect()->route('customer.name');


        }
    }
}
