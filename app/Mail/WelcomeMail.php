<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Http\Request;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $message;
    public $order;
    public $link;
    public function __construct($message=null,$order,$link=null)
    {
        //
        $this->message=$message;
        $this->order = $order;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {
     $input=$request->all();
     

        return $this->from($input['from'], 'Example')->subject($input['subject'])->markdown('mail.welcome-mail');
    }
}
