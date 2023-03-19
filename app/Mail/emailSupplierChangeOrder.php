<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class emailSupplierChangeOrder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;
    public $fullname;
    public $item;
    public function __construct($data, $item)
    {
        $this->data = $data;
        $this->item = $item;
        $this->fullname =  ucfirst($this->data['customer_first_name']) . ' '. ucfirst($this->data['customer_last_name']);
      //  dd($this->data); 

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject =  'Bettercaremarket Change Order' .$this->data['order_number'] . '-' . $this->fullname; 

        return $this->from(config('mail.mailers.mailingSupplier.username'),'BettercareMarket')->subject($subject)->markdown('mail.supplierChangeOrderMailTemplate')->with($this->data, $this->item);
       
    }
}
