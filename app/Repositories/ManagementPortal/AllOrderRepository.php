<?php 
namespace App\Repositories\ManagementPortal;


use App\Repositories\CommonRepository;
use App\Repositories\NdisInternalApiRepository;

use App\Http\Controllers\SendEmailSupplierController;
use App\Events\UpdateStatusToPAid;


use App\Models\BcmOrder;
use App\Models\BcmOrderItems;
use App\Models\Shipping;
use App\Models\Ticketing;
use App\Models\Comment;
use App\Models\EmailLogs;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use App\Repositories\NdisExternalApiRepository;
use Exception;

class AllOrderRepository
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function __construct(CommonRepository $common, NdisInternalApiRepository $ndisInternal,NdisExternalApiRepository $ndisExternal) {
        
        $this->common = $common;
        $this->ndisInternal = $ndisInternal;
        $this->ndisExternal = $ndisExternal;
    }


    //fecth All orders:including NDIA
    public function fetchAllOrders() {
       
        $ordersData = BcmOrder::select('bcm_order.order_number','bcm_order.order_date','bcm_order.order_status','bcm_order.customer_first_name','bcm_order.customer_last_name', 'bcm_order.shipping_address_first_name','bcm_order.shipping_address_last_name', 'bcm_order.assigned_to','bcm_order.order_total','bcm_order.shipping_total','bcm_order.gst_total','bcm_order.payment_option',
         DB::raw("CONCAT(bcm_order.shipping_address_street,' ',bcm_order.shipping_address_city, ' ',bcm_order.shipping_address_state,' ',bcm_order.shipping_address_post_code ) as shipping_address") 
        , 'ndisOrders.ndis_plan_management_option as ndis_type', 'supplier.invoice_number'  )                
         ->leftjoin('orders '.' as ndisOrders','ndisOrders.order_number', '=', 'bcm_order.order_number')
         ->leftjoin('supplier','supplier.order_id', '=', 'bcm_order.order_number')->groupBy('bcm_order.order_number');  
       ///DB::raw("MAX('supplier.invoice_number')
        return $ordersData;
    }

    public function getOrderShipping($id){
        $ordersData= Shipping::select('id','item_name','order_number','courier_company','tracking_number','expected_time_of_arrival','dispatch_time','notes')
        ->where('order_number','=',$id)

        ->get()->toArray();
       return $ordersData;
        
        // ->where('bcm_order.order_number',$id)->get()->toArray();
    }

    public function getOrderProducts($id) {
        
        $order_items_table = 'bcm_order_items';
        $ordersData = BcmOrder::select('order_number','order_status','oi.id as item_id', 'oi.item_size', 'oi.item_colour' ,'oi.supplier_order_date','item_name','item_quantity','item_price','oi.product_category_item','oi.item_sku','supplier.supplier_id')
            ->leftjoin($order_items_table.' as oi','bcm_order.order_number', '=', 'oi.order_id')
            ->where('bcm_order.order_number',$id)
           // ->leftjoin('supplier','oi.item_sku','=','supplier.product_sku' and )
            ->leftjoin('supplier', function($leftjoin){
                $leftjoin->on('oi.item_sku','=','supplier.product_sku')
                ->on('bcm_order.order_number','=','supplier.order_id');
            })
            ->get()->toArray();
       // dd($ordersData);
        return $ordersData;
    }

      /**
     * Update Order Status.
     *
     */
    public function updateOrderStatus($requestData) {

        $order = BcmOrder::where('order_number',$requestData['id'])->first();
        $updateStatus= $requestData['updateStatus']?intval($requestData['updateStatus']):null;
       
        if ($order && $updateStatus) {
            $orderStatus=config('ndis.newOrderStatus1');
          
            if( $order->order_status) 
            {$oldStatus=$orderStatus[$order->order_status]; }
            else{
                $oldStatus='ERROR';
            }  //dd($orderStatus[$updateStatus]);
                $comment='update order status from '. $oldStatus.' to '.  $orderStatus[$updateStatus];
                $order->order_status = $updateStatus;
               
                if ($order->save()) {

                    $order = $order->toarray();
                    // Event for sent auto email to supplier and planmanager when status chages to piad
                    if($order['order_status'] == 2 && $order['order_status']!= null){

                       $res =  event(new UpdateStatusToPAid($order));
                   
                        //update supplier order date in order ietms table
                        if($res[0]['status'] == 1){
                            BcmOrderItems::where('order_id',$order['order_number'])->update(['supplier_order_date' => date('Y-m-d h:i:s')]);  
                        }        
                    }else{
                        $res = true;
                    }
                    
                    try{
                        Comment::create(['order_number'=> $requestData['id'],'comment'=>$comment]);
                    }catch (Exception $e){
                        return false;
                    }
                return $res ;
                }
        }
        return false;
    }



    /**
     * Create Trackin details.
     *
     */
    public function createTrackingRecord($requestData) {
            if(count($requestData['item_name']) >0 ){
                for($i=0; $i<count($requestData['item_name']); $i++){
                    $shipping = Shipping::Create([
                        'order_number'    => $requestData['orderId'],
                        'tracking_number' => $requestData['trackingNumber']?$requestData['trackingNumber']:null,
                        'courier_company' => $requestData['courierCompany']?$requestData['courierCompany']:null,
                        'expected_time_of_arrival' => $requestData['eta']?$requestData['eta']:null,
                        'dispatch_time' => $requestData['dispatchTime']?$requestData['dispatchTime']:null,
                        'supplier_id' => $requestData['SupplierId']?$requestData['SupplierId']:null,
                        'notes' => $requestData['tracking_notes']?$requestData['tracking_notes']:null,
                        'product_sku' => $requestData['product_sku']?$requestData['product_sku'][$i]:null,
                        'item_name' => $requestData['item_name']?$requestData['item_name'][$i]:null
                    ]);
                }

            }
             
        if ($shipping){
            return true;
        } else{
            return false;
        };
    }



        /**
     * Edit Order Item.
     *
     */
    public function editOrderTracking($requestData) {
        $shipping = Shipping::where('id',$requestData['id'])->first();
        // dd($requestData);
        foreach($requestData as $key => $val) {
            if($key && $key !== 'id'){
                $shipping->$key=$val;
            }
          }
          if ($shipping->save()) {
            return true;
         }
         return false;
     }
        /**
     * Edit Order Item.
     *
     */
     public function editOrderItems($requestData, $id = '') {
        $orderItem = BcmOrderItems::where('id',$requestData['id'])->first();
        // dd($requestData);
        foreach($requestData as $key => $val) {
            if($key && $key !== 'id' && $key!=='order_number'){
                $orderItem->$key=$val;
            }
          }
          if ($orderItem->save()) {
            return true;
         }
         return false;
     
     }

        /**
     * get All tickets.
     *
     */
    public function getAllTickets($requestData) {
        
        if (array_key_exists("id_ticket",$requestData)){
           
           // $tickets = Ticketing::whereDate('due_date', '<=', now()->format('Y-m-d'))
             // ->where('status','!=','closed')
            //->where('order_number',$requestData['id_ticket'])->orderBy('created_at','desc')->get()->toArray();

            $tickets = Ticketing::where('order_number',$requestData['id_ticket'])->orderBy('created_at','desc')->get()->toArray();
           
        }
        elseif(array_key_exists('ticketId',$requestData)&&$requestData['ticketId']){

            $tickets = Ticketing::where('id',$requestData['ticketId'])->get()->toArray();

        }
        else{
          
            $tickets = Ticketing::orderBy('created_at','desc')->get()->toArray();
            
        }
        
        //remove view order button from action column

        // if(array_key_exists("order_page",$requestData) ){
        //   echo "hh";
        // }
        
         return $tickets;
     
     }

           /**
     * Update Ticket Status.
     *
     */
    public function updateTicketStatus($requestData) {
        if(array_key_exists('id',$requestData)&array_key_exists('updateStatus',$requestData)){

            $ticket = Ticketing::where('id',$requestData['id'])->first();
            $updateStatus= $requestData['updateStatus']?$requestData['updateStatus']:null;
            
            if ($ticket && $updateStatus) {
                    $ticket->status = $updateStatus;
                    // dd($ticket);
                    if ($ticket->save()) {
                        return true;
                    }
            }
            return false;

        }
        
    }
    //create Tickets

    public function createTicket($requestData) {
         
        
        $ticket = Ticketing::Create([
            'status'    => $requestData['status'],
            'order_number' => $requestData['order_number']?$requestData['order_number']:null,
            'due_date' => $requestData['due_date']?$requestData['due_date']:null,
            'subject' => $requestData['subject']?$requestData['subject']:null,
            'notes' => $requestData['notes']?$requestData['notes']:null,
            'type' => $requestData['order_number']?'0':'1',

        ]);
        // dd($ticket);
        if($ticket){
            return true;
        } else{
            return false;
        };
    
    
    }

    public function getOrderComments($requestData) {
        
        if (array_key_exists("orderNumber",$requestData)){
            $comments = Comment::where('order_number',$requestData['orderNumber'])->orderBy('created_at','desc')->get()->toArray();
            if(count($comments)==0){
            
                return [];
            }
             return $comments;
        } else{
            return [];
        }
        
    
        
     
     }

     public function createOrderComment($requestData) {
        //  dd($requestData);
        if (array_key_exists("orderNumber",$requestData)){
            $comment = Comment::Create([
                'comment'    => $requestData['comment'],
                'order_number' => $requestData['orderNumber']
            ]);

        }
        
        return $comment;
    
    
    }

    public function getOneOrderData($id)
    {
        $order_items_table = 'bcm_order_items';
        $ordersData = BcmOrder::select('order_number','order_date','customer_first_name','customer_last_name', 'customer_phone_number', 'order_comment','payment_option',
                                        'shipping_address_first_name','shipping_address_last_name','shipping_address_street','shipping_address_city','shipping_address_state',
                                        'shipping_address_post_code','shipping_address_company','contact_phone_number','oi.item_name','oi.item_quantity','supplier.supplier_id',
                                        'supplier.supplier_name','supplier.supplier_emailid','supplier.product_sku')
            ->leftjoin($order_items_table.' as oi','bcm_order.order_number', '=', 'oi.order_id')
            ->where('bcm_order.order_number',$id)
           // ->leftjoin('supplier' ,'bcm_order.order_number','=','supplier.order_id')
            ->leftjoin('supplier', function($leftjoin){
                $leftjoin->on('oi.item_sku','=','supplier.product_sku')
                ->on('bcm_order.order_number','=','supplier.order_id');
           })
            ->get()->toArray();
       // dd($ordersData); exit;
        return $ordersData;
    }
     
    public function getOneSupplierOrderData($orderNumber, $supplier_id){
        $order_items_table = 'bcm_order_items';
        $ordersData = BcmOrder::select('order_number','order_date','customer_first_name','customer_last_name', 'customer_phone_number', 'order_comment','payment_option',
                                        'shipping_address_first_name','shipping_address_last_name','shipping_address_street','shipping_address_city','shipping_address_state',
                                        'shipping_address_post_code','shipping_address_company','contact_phone_number','oi.item_name','oi.item_quantity','oi.item_price','supplier.supplier_id',
                                        'supplier.supplier_name','supplier.supplier_emailid','supplier.product_sku')
            ->leftjoin($order_items_table.' as oi','bcm_order.order_number', '=', 'oi.order_id')
            ->where(['bcm_order.order_number' => $orderNumber, 'supplier.supplier_id' => $supplier_id ] )
            ->leftjoin('supplier', function($leftjoin){
                $leftjoin->on('oi.item_sku','=','supplier.product_sku')
                ->on('bcm_order.order_number','=','supplier.order_id');
           })
            ->get()->toArray();
       // dd($ordersData); exit;
        return $ordersData;

    }

    /** 
     * Get plan managed orders by order number
     * 
     */
    public function getSinglePlanManagedOrder($order_number){
        $orderData = BcmOrder::select('bcm_order.order_number','bcm_order.customer_email','ndisOrders.ndis_plan_management_option as ndis_type',
        DB::raw("CONCAT(bcm_order.customer_first_name,' ',bcm_order.customer_last_name ) as customer_full_name") )
         ->leftjoin('orders '.' as ndisOrders','ndisOrders.order_number', '=', 'bcm_order.order_number')
         ->where('bcm_order.order_number' ,$order_number)->first()->toarray();    
        return $orderData;
    }



    /** 
     * Get email logs data for orders
     * 
     */
    public function getEmailLogsPage($orderNumber){
        $ordersData= EmailLogs::select('subject','to','from','cc','bcc','email_sent_date')
        ->where('order_number',$orderNumber)
        ->get()->toArray();
      //  print_r($ordersData);
       return $ordersData;
    }


    /** 
     * Get supplier invoices
     * 
     */
    public function getSupplierInvoice(){
        $data = Supplier::select('invoice_number');
        return $data;
    }


}

