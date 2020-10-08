<?php

namespace Modules\Orders\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Orders\Entities\Models\Order;
use Modules\Orders\Repositories\OrderRepository;

class SendOrderStatusEmail extends Mailable
{
    use Queueable, SerializesModels;
    private $order;
    public $subject;
    private $isCancel;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, $subject, $isCancel)
    {
        $this->order = $order;
        $this->subject = $subject;
        $this->isCancel = $isCancel;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        logger('Send order email log');
        logger($this->order);
        logger('end mail');
        $order = $this->order;
        $isCancel = $this->isCancel;
//        $sub = $this->subject;
        logger($order);
        logger('Order logger');
//        if ($this->isCancel == true) {
            return $this->subject($this->subject)->view(' orders::emails.orderMail')->with(['order' => $order, 'isCancel' => $isCancel]);;
//        }
//        return $this->subject($this->subject)->view(' orders::emails.orderMail')->with(['order' => $order]);;
    }
}
