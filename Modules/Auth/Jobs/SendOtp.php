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
//        $base_url_non_masking = 'http://smscp.datasoftbd.com/smsapi/non-masking';
//        $api_key = '$2y$10$nCixye2JmYu8p65XRv.yFeuMV4mc4BBko4KZ6XpmwEDiaEqfh1h2O';
//        $message = "Your OTP code is " . $this->otp;

        $base_url = 'https://smsplus.sslwireless.com/api/v3/send-sms';
        $api_token = '9650d63a-d586-4f06-925b-e9abe6ca0225';
        $sid = 'SUBIDHABRAND';
        $message = "Your OTP code is " . $this->otp . '- Subidha';
        $csms_id = $this->unique_code();

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

        $url = $base_url . "?api_token=" . $api_token . "&sid=". $sid . "&sms=" .$message ."&msisdn=" .$phone. "&csms_id=" .$csms_id ;

        // datasoftbd url
//        $url = $base_url_non_masking . "?api_key=" . $api_key . "&smsType=text&mobileNo=" . $phone . "&smsContent=" . $message;

        $client = new Client();
        try {
            $client->get($url);
            logger('SMS info');
            logger($csms_id);
            logger($url);
            logger($this->otp);

            OneTimePassword::create([
                'phone_number' => $this->phone_number,
                'otp' => $this->otp
            ]);
        } catch (GuzzleException $exception) {
        }

        //             sslwireless sms configuration
//
//            $user = config("message.sms_user");
//            $pass = config("message.sms_pass");
//            $sid = config("message.sms_sid");
//          $url = "http://sms.sslwireless.com/pushapi/dynamic/server.php";
//          $response = $client->request('POST', $url, [
//                'form_params' => [
//                    'user' => $user,
//                    'pass' => $pass,
//                    'sid'  => $sid,
//                    'sms'  => [
//                        [$phone, $message],
//                    ],
//                ],
//            ]);
    }
    function unique_code()
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 5);
    }
}
