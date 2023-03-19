<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
class longDelayMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    
    public $order;
    public $product;
    public $data;
    public function __construct($data,$order)
    {
        //
        $product = $data['product'];
        $this->product = $product;
        $this->order = $order;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        
        $subject='Bettercaremarket order '.$this->order->toArray()['order_number'].' – temporarily out of stock';

        return $this->from(config('mail.mailers.maillingCustomer.username'), 'BettercareMarket')->subject($subject)->markdown('mail.longDelayMailTemplate');
    }
}
