<?php

namespace Modules\Auth\Jobs;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Auth\Entities\Models\OneTimePassword;

class SendOtp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $phone_number, $otp;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($phone_number, $otp)
    {
        $this->phone_number = $phone_number;
        $this->otp = $otp;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $base_url_non_masking = 'http://smscp.datasoftbd.com/smsapi/non-masking';

        $api_key = '$2y$10$nCixye2JmYu8p65XRv.yFeuMV4mc4BBko4KZ6XpmwEDiaEqfh1h2O';

        $message = "Your OTP code is " . $this->otp;

        $phone = $this->phone_number;

        $checked_digit = substr($phone, 0, 3);
        if ($checked_digit == '+88') {
            $phone = ltrim($phone, '+');
        }
        $checked_zero = substr($phone, 0, 1);
        if ( $checked_zero == 0 ) {
            $phone = '88' . $phone;
        }
        $checked_lastest = substr($phone, 0, 3);
        if ( $checked_lastest !== '880') {
            $phone = ltrim($phone, '88');
            $phone = '880' . $phone;
        }
        logger('phone '. $phone);

        $url = $base_url_non_masking . "?api_key=" . $api_key . "&smsType=text&mobileNo=" . $phone . "&smsContent=" . $message;
        $client = new Client();
        try {
//            $response = $client->request('GET', $url);
            logger('Send sms');
            $request = $client->get($url);
            logger($request->getBody());
            OneTimePassword::create([
                'phone_number' => $this->phone_number,
                'otp' => $this->otp
            ]);
        } catch (GuzzleException $exception) {
            logger($exception);
        }

//        $message = "Your OTP code is " . $this->otp;
//        $user = config('auth.sms.sms_user');
//        $pass = config('auth.sms.sms_pass');
//        $sid = config('auth.sms.sms_sid');
//        $url = "http://sms.sslwireless.com/pushapi/dynamic/server.php";
//        $client = new Client();
//        try {
//            $response = $client->request('POST', $url, [
//                'form_params' => [
//                    'user' => $user,
//                    'pass' => $pass,
//                    'sid'  => $sid,
//                    'sms'  => [
//                        [$this->phone_number, $message],
//                    ],
//                ],
//            ]);
//            OneTimePassword::create([
//                'phone_number' => $this->phone_number,
//                'otp' => $this->otp
//            ]);
//        }
//        catch (GuzzleException $exception) {
//            logger($exception);
//        }
    }
}
