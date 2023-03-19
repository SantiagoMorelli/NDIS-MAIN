<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ndisFundReceivedEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $orderNumber;
    public $orderData; 
    public $customer_full_name;

    public function __construct($orderNumber,$orderData)
    {
        $this->orderNumber = $orderNumber;
        $this->orderData = $orderData;
        $this->customer_full_name =  ucfirst($orderData['customer_full_name']);
       
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "We have received the funds for order number " . $this->orderNumber;
        return $this->from(config('mail.mailers.maillingCustomer.username'), 'BettercareMarket')->subject($subject)->markdown('mail.ndisFundReceivedMailTemplate');
      
    }
}
