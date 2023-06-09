<?php

namespace App\Mail;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendTrackingMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $tracking;
    public $order;
    public $comments;
    public function __construct($tracking,$order,$comments)
    {
        //
        $this->tracking = $tracking;
        $this->order = $order;
        $this->comments = $comments;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build(Request $request)
    {
        $input=$request->all();
        $subject='Bettercaremarket order '.$this->order->toArray()['order_number'].' – Dispatch Upate';
        // config('mail.mailers.test.username');
    //    dd($this->tracking);
        
        return $this->from(config('mail.mailers.maillingCustomer.username'), 'BettercareMarket')->subject($subject)->markdown('mail.emailTrackingTemplate');
        
    }
}
