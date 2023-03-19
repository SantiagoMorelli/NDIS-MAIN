<?php

namespace App\Listeners;

use App\Events\UpdateStatusToPAid;
use App\Http\Controllers\AllOrderController;
use App\Http\Controllers\SendEmailSupplierController;
use App\Http\Controllers\MailController;
use App\Repositories\CommonRepository;
use App\Repositories\ManagementPortal\AllOrderRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendAutoEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    public function __construct(MailController $email, AllOrderRepository $allOrder, CommonRepository $common, SendEmailSupplierController $emailToSupplier)
    {
        $this->emailToSupplier = $emailToSupplier;
        $this->common = $common;
        $this->allOrder = $allOrder;
        $this->email = $email;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UpdateStatusToPAid  $event
     * @return void
     */
    public function handle(UpdateStatusToPAid $event)
    {
        $order = $event->order;
        if($order['order_status'] == 2){
            $success= $this->emailToSupplier->emailOnStatusChangedToPaid( $order['order_number']);

            // If ndis order is plan managed send email to plan manager
             if($order['payment_option'] == 'ndis'){

                //get NDIS plan managment option from order table 

                $orderData = $this->allOrder->getSinglePlanManagedOrder($order['order_number']);
                $ndis_type =  $this->common->encrypt_decrypt($orderData['ndis_type'],'decrypt');

                if($ndis_type == config('ndis.plan_management_option.plan_managed')){
                   $response =  $this->email->ndisFundReceivedEmail( $order['order_number'] , $orderData);
                }
            }

            if($success == 1 && isset($response) && $response==1) {
                return    ['status'=>'1','message'=>'Successfully update the ndis order status to paid and sent an email to supplier and customer'];    
             } else if($success == 1){
                return    ['status'=>'1','message'=>'Successfully update the order status and sent email to supplier'];
             } else if(isset($response) && $response==0){
                return    ['status'=>'0','message'=>'Successfully update the order status but fail to sent an email to customer'];
             } else{
                return    ['status'=>'0','message'=>'Successfully update the order status but fail to sent an email to supplier'];
             }
        }
               
    }
}
