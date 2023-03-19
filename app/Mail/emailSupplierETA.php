<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class emailSupplierETA extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $valid_sku;
    public function __construct($valid_sku)
    {
       // dd($valid_sku);
        $this->valid_sku = $valid_sku;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject =  'ETA Request for Products on Backorder'; 
        return $this->from(config('mail.mailers.mailingSupplier.username'),'BettercareMarket')->subject($subject)->markdown('mail.supplierETAMailTemplate')->with($this->valid_sku);
    }
}
