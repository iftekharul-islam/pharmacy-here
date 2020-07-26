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

        $message = "Your OTP code is " . $this->otp;
        $user = config('auth.sms.sms_user');
        $pass = config('auth.sms.sms_pass');
        $sid = config('auth.sms.sms_sid');
        $url = "http://sms.sslwireless.com/pushapi/dynamic/server.php";
        $client = new Client();
        try {
            $response = $client->request('POST', $url, [
                'form_params' => [
                    'user' => $user,
                    'pass' => $pass,
                    'sid'  => $sid,
                    'sms'  => [
                        [$this->phone_number, $message],
                    ],
                ],
            ]);
            OneTimePassword::create([
                'phone_number' => $this->phone_number,
                'otp' => $this->otp
            ]);
        }
        catch (GuzzleException $exception) {
            logger($exception);
        }
    }
}