<?php

namespace Modules\Orders\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Orders\Repositories\OrderRepository;

class SendOrderStatusEmail extends Mailable
{
    use Queueable, SerializesModels;
    private $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        logger('Send order email log');
        logger($this->message);
        logger('end mail');
        $msg = $this->message;
        logger($msg);
        return $this->view(' orders::emails.orderMail')->with(['msg' => $msg]);;
    }
}
