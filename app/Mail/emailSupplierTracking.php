<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class emailSupplierTracking extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $data; 
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $subject =  'Bettercaremarket Order No' .$this->data['orderNumber'] . '- tracking Number Request'; 
        return $this->from(config('mail.mailers.mailingSupplier.username'),'BettercareMarket')->subject($subject)->markdown('mail.supplierTrackingMailTemplate')->with($this->data);
    }
}
