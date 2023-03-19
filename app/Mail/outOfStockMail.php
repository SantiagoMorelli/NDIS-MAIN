<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
class outOfStockMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $product;
    public $data;
    public $order;
    public function __construct($data,$order)
    {
        
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
        // $input=$request->all();
        $subject='Bettercaremarket order '.$this->order->toArray()['order_number'].' – temporarily out of stock';
// config('mail.mailers.maillingCustomer.username')
        return $this->from(config('mail.mailers.maillingCustomer.username'), 'BettercareMarket')->subject($subject)->markdown('mail.outOfStockMailTemplate');
        
    }
}
