<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class emailSupplier extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $supplier_name;
    public $data;


    public function __construct($supplier_name ,$data)
    {
    
        $this->data = $data; 
        $this->supplier_name = $supplier_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        $subject=$this->data['subject'];

        return $this->from(config('mail.mailers.mailingSupplier.username'),'BettercareMarket')->subject($subject)->markdown('mail.emailSupplierMailTemplate');

    }
}
