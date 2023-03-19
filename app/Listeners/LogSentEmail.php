<?php

namespace App\Listeners;

use App\Events\HistoryForSentEmails;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;

use App\Models\EmailLogs;



class LogSentEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Providers\HistoryForSentEmails  $event
     * @return void
     */
    public function handle()
    {
    }
      
    public function AllEmailLogging(MessageSent $event){
     // dd('in Message');
        $to = array_keys($event->message->getTo());
        $to = implode(" ", $to);
        $from = array_keys($event->message->getFrom());
        $from = implode(",", $from);
        if($event->message->getCc() != null){
            $cc = array_keys($event->message->getCc());
        }
        //for supplier email templates related to orders
        if(isset($event->data['orderNumber'])){
             $order_number = $event->data['orderNumber'];
        }
        //for --
        else if(isset($event->data['order_number'])){
             $order_number = $event->data['order_number'];
        }
        //for long delay and short delay email
        else if(isset($event->data['data']['order_number'])){
            $order_number = $event->data['data']['order_number'];
        }
        // for tracking mail sent to customer
        else if(isset($event->data['tracking'][0][0])){
            $order_number = $event->data['tracking'][0][0];
        }
        
         $subject           = $event->message->getSubject();
         $email_sent_date   = $event->message->getDate()->format('Y-m-d H:i:s');
         $to                = $to;
         $from              = $from;
         $cc                = isset($cc)?$cc:Null;
         $order_number      = isset($order_number)?$order_number:NULL;


         //print_r($event->data['tracking'][0][0]);
         //dd($event);
        EmailLogs::create([  
            'from'      => $from,
            'to'        => $to,
            'cc'        => $cc,
            'subject'   => $subject,
            'email_sent_date' => $email_sent_date,
            'order_number' => $order_number
        ]);

        return true;

    }

    public function AutomaticSupplierEmailLogging(HistoryForSentEmails $event){
       // dd($event);
        $from  =$event->message->getFrom()->getEmail();
        $to = $event->message->getPersonalization()->getTos()[0]->getEmail();
        $cc = $event->message->getPersonalization()->getCcs()[0]->getEmail();
        if(!empty($event->message->getPersonalization()->getBccs())){
            $bcc = $event->message->getPersonalization()->getBccs()[0]->getEmail();
        }
        $subject = $event->message->getGlobalSubject()->getSubject();
        $email_sent_date = now();
        $order_number = $event->order_number;        
     
        $res = EmailLogs::create([  
            'from'      => $from,
            'to'        => $to,
            'cc'        => $cc,
            'bcc'       => isset($bcc)?$bcc:null,
            'subject'   => $subject,
            'email_sent_date' => $email_sent_date,
            'order_number' => $order_number
        ]);
      //  dd($res);

        return true;
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe(DispatcherContract $events){
        $events->listen(
            'App\Events\HistoryForSentEmails',
            'App\Listeners\LogSentEmail@AutomaticSupplierEmailLogging'
        );
        $events->listen(
            'Illuminate\Mail\Events\MessageSent',
            'App\Listeners\LogSentEmail@AllEmailLogging'
        );
    }
    
}
