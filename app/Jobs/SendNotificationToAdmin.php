<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Modules\Orders\Emails\SendOrderStatusEmail;

class SendNotificationToAdmin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private $order;
    private $subject;
    private $isCancel;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order, $subject, $isCancel)
    {
        $this->order = $order;
        $this->subject = $subject;
        $this->isCancel = $isCancel;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $toMailAddress = config('mailto.mail_to_address');
        Mail::to($toMailAddress)->send( new SendOrderStatusEmail($this->order, $this->subject, $this->isCancel));
    }
}
