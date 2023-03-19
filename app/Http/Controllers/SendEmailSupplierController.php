<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\BcmOrders;
use Illuminate\Support\Facades\Response;
use App\Models\BcmOrderItems;
use App\Models\Suppliers;
use Mpdf\Utils\Arrays;
use App\Services\Api;
use Exception;
use niklasravnsborg\LaravelPdf;
use Elibyy\TCPDF\Facades\TCPDF;
// use pdf;
use Illuminate\Support\Facades\Mail;
// use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\log;
// use Dompdf\Dompdf;
// use App\Services\CustomPDF;
use App\Repositories\CommonRepository;
use App\Repositories\NdisAuthenticationRepository;
use App\Repositories\NdisExternalApiRepository;
use App\Repositories\ManagementPortal\AllOrderRepository;
use App\Events\HistoryForSentEmails;


//use App\Http\Controllers\NdisInternalApiController;
use Illuminate\Support\Arr;
use PDF;
use Config;

// use Barryvdh\DomPDF\PDF;

use Sabberworm\CSS\Value\PrimitiveValue;

class SendEmailSupplierController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CommonRepository $common, NdisAuthenticationRepository $ndisAuthentication, NdisExternalApiRepository $ndisExternal, AllOrderRepository $order)
    {
        $this->common = $common;
        $this->ndisAuthentication = $ndisAuthentication;
        $this->ndisExternal = $ndisExternal;
        $this->order = $order;
        //  $this->internalapi = $internalapi;
    }

    public function show(Request $request)
    {
   
            $value = $request->json()->all();
            $em = array();
            $email_unique = array();
            $unique_supplier_id =array();
            $em = $this->getUniqueEmailId($request);
            $em1 = $this->getUniqueSupplierId($request);
            $email_unique = array_unique($em);
            $unique_supplier_id = array_unique($em1);
           // print_r($unique_supplier_id);
          // dd($email_unique);
          //  $arrayLength = count($email_unique);
           // echo $arrayLength;
           // echo "\n";

            // foreach ($email_unique as $email_val) {
            //     $cart = array();
            //     $i = 0;
            //     foreach ($value['order_items'] as $item) {
            //         $ar = preg_split("/[-,|]+/", $item['product_supplier']);
                   
            //         if ($email_val == trim($ar[2]) ) {
            //             array_push($cart, $item);
            //         } else if ($email_val != trim($ar[2])) {
            //             continue;
            //         }
            //         $i++;
            //     }


            // send email to supplier according to supplier unique id.
            foreach ($unique_supplier_id as $sid_val) {
                $cart = array();
                $i = 0;
                foreach ($value['order_items'] as $item) {
                    $ar = preg_split("/[-,|]+/", $item['product_supplier']);
                   
                    if ($sid_val == trim($ar[0]) ) {
                        $email_val = trim($ar[2]);
                        array_push($cart, $item);
                    } else if ($sid_val != trim($ar[1])) {
                        continue;
                    }
                    $i++;
                }
               // dd($cart);
              
                //send email to supplier if order status is set to paid

                if($value['order_status'] == '2' && $value['order_status'] != null)
                {
                    $this->sendEmailToSupplier($value, $cart, $email_val, $ar);    
                }
                
                unset($cart);
            }
           
            $order = new BcmOrders();
            $order->order_number = $value['order_number'];
            $order->order_date = $value['order_date'];
            $order->order_discount = $value['order_discount'];
            $order->order_status = $value['order_status'];
           // $order->customer_date_of_birth   = $value['customer_date_of_birth'];
            $order->shipping_total = $value['shipping_total'];
            $order->order_total = $value['order_total'];
            $order->customer_first_name = $value['customer_first_name'];
            $order->customer_last_name = $value['customer_last_name'];
			$order->customer_email = $value['customer_email'];
            $order->customer_phone_number = $value['contact_phone_number'];
            $order->order_comment = $value['order_comment'];

            $order->billing_address_first_name = $value['billing_address_first_name'];
            $order->billing_address_last_name = $value['billing_address_last_name'];
            $order->billing_address_company = $value['billing_address_company'];
            
            $order->billing_address_street = $value['billing_address_street'];
            $order->billing_address_city = $value['billing_address_city'];
            $order->billing_address_state = $value['billing_address_state'];
            $order->billing_address_post_code = $value['billing_address_post_code'];
            
            $order->shipping_address_first_name = $value['shipping_address_first_name'];
            $order->shipping_address_last_name = $value['shipping_address_last_name'];
            $order->shipping_address_company = $value['shipping_address_company'];

            $order->shipping_address_street = $value['shipping_address_street'];
            $order->shipping_address_state  = $value['shipping_address_state'];
            $order->shipping_address_city = $value['shipping_address_city'];
            $order->shipping_address_post_code = $value['shipping_address_post_code'];
            $order->payment_option = $value['payment_method'];
            if ($order->save()) {
                $orderId = $order->order_number;
                $orderItems = $this->saveOrderItems($value, $orderId);
                $this->saveSupplierData($value, $orderId);
                return $orderId;
            }
            return false;
            // $order->save();


            return response()->json(['message' => 'order details added successfully']);
        
    }

    /**
     * Save Order items.
     *
     */
    public function saveOrderItems($value, $orderId)
    {
        if (isset($value['order_items']) && $value['order_items']) {
            $orderItemDelete = BcmOrderItems::where('order_id', $orderId)->delete();

            if($value['order_status'] == '2' && $value['order_status'] != null){

               // echo "if"; exit;

                foreach ($value['order_items'] as $ord_value) {
                    $orderItems = new BcmOrderItems();
    
    
                    $orderItems->order_id = $orderId;
                    $orderItems->item_name = $ord_value['item_name'];
                    $orderItems->item_sku = $ord_value['product_sku'];
                    $orderItems->item_quantity = $ord_value['item_quantity'];
                    $orderItems->item_price = $ord_value['item_price'];
                    $orderItems->item_size = $ord_value['product_size'];
                    $orderItems->item_colour = $ord_value['product_colour'];
                    $orderItems->supplier_order_date = date('Y-m-d h:i:s');
                    $orderItems->order_place_to_supplier_userid = 0;
                    //$orderItems->product_category = $ord_value['product_category'];
                    //$orderItems->product_category_item = $ord_value['product_category_item'];
                    $orderItems->save();
                }
            }else{
              //  echo "else"; exit;
                foreach ($value['order_items'] as $ord_value) {
                    $orderItems = new BcmOrderItems();
    
    
                    $orderItems->order_id = $orderId;
                    $orderItems->item_name = $ord_value['item_name'];
                    $orderItems->item_sku = $ord_value['product_sku'];
                    $orderItems->item_quantity = $ord_value['item_quantity'];
                    $orderItems->item_price = $ord_value['item_price'];
                    $orderItems->item_size = $ord_value['product_size'];
                    $orderItems->item_colour = $ord_value['product_colour'];
                    //$orderItems->product_category = $ord_value['product_category'];
                    //$orderItems->product_category_item = $ord_value['product_category_item'];
                    $orderItems->save();
                }
            }
           
            return true;
        }
        return false;
    }

    /**
     * Save Supplier details.
     *
     */


    public function saveSupplierData($value, $orderId)
    {
        $em = "";
        if (isset($value['order_items']) && $value['order_items']) {
            foreach ($value['order_items'] as $ord_value) {
                $arr = preg_split("/[-,|]+/", $ord_value['product_supplier']);
                $supplier = new Suppliers();
                $supplier->supplier_id = $arr[0];
                $supplier->supplier_name = $arr[1];
                $supplier->order_id = $orderId;
                $supplier->product_sku = $ord_value['product_sku'];
                $supplier->supplier_emailid = $arr[2];
                $supplier->invoice_number = isset($value['invoice_no'])? $value['invoice_no']: null;
                $supplier->save();

                // $this->sendEmailToSupplier($value, $arr);

                // $arr = "";
            }
            return true;
        }
        return false;


        //         $string = "9 - Rehab and Mobility | barath@bettercaremarket.com.au";
        // $keywords = preg_split("/[-,|]+/", $string);
        // echo $keywords[0];


    }

    /**
     * Send Email to Suppliers.
     *
     */

    public function sendEmailToSupplier($value, $cart=null, $email_val=null, $ar=null)
    {

      
            if($value && $cart != null)
            {
                foreach ($cart as $car_val) {
                    $name = preg_split("/[-,|]+/", $car_val['product_supplier']);
                  // echo  $details['supplier_id'] = $name[0];
                    $details['supplier_name'] = $name[1];  
                    $details['supplier_emailid'] = trim($name[2]);
                }
            
                $to_email = trim($email_val);
                $details['order_date'] = $value['order_date'];
                $details['order_number'] = $value['order_number'];
                // $details['suuplier_name'] = $ar[1];
                // $details['supplier_emailid'] = $ar[2];
                $details['customer_firstanme'] = $value['customer_first_name'];
                $details['customer_lastanme'] = $value['customer_last_name'];
                $details['customer_phone_number'] = $value['contact_phone_number'];
                $details['contact_phone_number'] = isset($value['contact_phone_number'])? $value['contact_phone_number']: '';
                $details['order_comment'] = $value['order_comment'];

        
                //  $details['customer_date_of_birth'] = $value['customer_date_of_birth'];

                $details['billing_address_first_name'] = $value['billing_address_first_name'];
                $details['billing_address_last_name'] = $value['billing_address_last_name'];
                $details['billing_address_company'] = $value['billing_address_company'];

                $details['billing_address_street'] = $value['billing_address_street'];
                $details['billing_address_state'] = $value['billing_address_state'];
                $details['billing_address_city'] = $value['billing_address_city'];
                $details['billing_address_post_code'] = $value['billing_address_post_code'];

                $details['shipping_address_first_name'] = $value['shipping_address_first_name'];
                $details['shipping_address_last_name'] = $value['shipping_address_last_name'];
                $details['shipping_address_company'] = $value['shipping_address_company'];    

                $details['shipping_address_street'] = $value['shipping_address_street'];
                $details['shipping_address_state'] = $value['shipping_address_state'];
                $details['shipping_address_city'] = $value['shipping_address_city'];
                $details['shipping_address_post_code'] = $value['shipping_address_post_code'];

            }
            else{
                //  email to supplier for NDIS orders after order status changes to paid 
                //dd($value);
                $to_email = trim($email_val);
                $details['order_date'] = $value[0]['order_date'];
                $details['order_number'] = $value[0]['order_number'];
                $details['supplier_name'] = $value[0]['supplier_name'];
                $details['supplier_emailid'] = $value[0]['supplier_emailid'];
                $details['customer_firstanme'] = $value[0]['customer_first_name'];
                $details['customer_lastanme'] = $value[0]['customer_last_name'];
                $details['customer_phone_number'] = $value[0]['customer_phone_number'];
 
                $details['contact_phone_number'] = $value[0]['contact_phone_number']; 
                $details['order_comment'] = $value[0]['order_comment'];

        
                $details['billing_address_first_name'] = '';
                $details['billing_address_last_name'] = '';
                $details['billing_address_company'] = '';

                $details['billing_address_street'] = '';
                $details['billing_address_state'] = '';
                $details['billing_address_city'] = '';
                $details['billing_address_post_code'] = '';

                $details['shipping_address_first_name'] = $value[0]['shipping_address_first_name'];
                $details['shipping_address_last_name'] = $value[0]['shipping_address_last_name'];
                $details['shipping_address_company'] = $value[0]['shipping_address_company'];    

                $details['shipping_address_street'] = $value[0]['shipping_address_street'];
                $details['shipping_address_state'] = $value[0]['shipping_address_state'];
                $details['shipping_address_city'] = $value[0]['shipping_address_city'];
                $details['shipping_address_post_code'] = $value[0]['shipping_address_post_code'];


              
            }

         //   dd($value);
        $data = [
            'order_date'                => $details['order_date'],
            'order_number'              => $details['order_number'],
            'supplier_name'             => $details['supplier_name'],

            'supplier_emailid'          => $details['supplier_emailid'],

            'customer_firstname'        => $details['customer_firstanme'],
            'customer_lastname'         => $details['customer_lastanme'],
            'customer_phone_number'     => $details['customer_phone_number'],
            'contact_phone_number'     => $details['contact_phone_number'],
            'order_comment'             => $details['order_comment'],
            'billing_address_street'    => $details['billing_address_street'],
            'billing_address_state'     => $details['billing_address_state'],
            'billing_address_city'      => $details['billing_address_city'],
            'billing_address_post_code' => $details['billing_address_post_code'],

            'shipping_address_first_name' => $details['shipping_address_first_name'],
            'shipping_address_last_name'  => $details['shipping_address_last_name'],
            'shipping_address_company'    => $details['shipping_address_company'],

            'shipping_address_street'     => $details['shipping_address_street'],
            'shipping_address_state'      => $details['shipping_address_state'],
            'shipping_address_city'       => $details['shipping_address_city'],
            'shipping_address_post_code'  => $details['shipping_address_post_code'],

            'product_items' => isset($cart)?$cart:$value,


        ];

       
//sendgrid
 $email = new \SendGrid\Mail\Mail();
        $from     = config('ndis.email.from_email');
       $cc       = config('ndis.email.cc_user_email');
       $cc       = 'nimitdudani@gmail.com';
        if ($cc) {
            $email->addCc($cc, "");
        }
        $email->setFrom($from, config('ndis.email.sender'));

        // specify the email/name we are sending the email to
       // dd($to_email);
        $email->addTo($to_email);
       // $email->addTo('misbah@bettercaremarket.com.au');

        $body = view('supplier')->with($data)->render();
        $email->addContent("text/html", $body);
        
        // Send to supplier
        if(isset($value['payment_method']) && strtolower($value['payment_method']) != 'ndis' )
        {
            // set the email subject line
            $email->setSubject('Bettercaremarket order #'.$value['order_number'].' - '.$value['shipping_address_first_name']." ".$value['shipping_address_last_name']);
            // create new sendgrid
            $sendgrid = new \SendGrid(config('ndis.email.sendgrid_key'));

            try {
                // try and send the email
                $response = $sendgrid->send($email);

                event(new HistoryForSentEmails($email,$details['order_number']));

                //print out response data
                print $response->statusCode() . "\n";
                print_r($response->headers());
                print $response->body() . "\n";
            } catch (Exception $e) {
                // something went wrong so display the error message
                echo 'Caught exception: ' . $e->getMessage() . "\n";
            }
        }
        else
        {
            $email->setSubject('NDIS Supplier Copy : Bettercaremarket order #'.$details['order_number'].' - '.$details['shipping_address_first_name']." ".$details['shipping_address_last_name']);

            $sendgrid = new \SendGrid(config('ndis.email.sendgrid_key'));

            try {
                // try and send the email
                ///$response = $sendgrid->send('nirav@pharmengage.com');
                $response = $sendgrid->send($email);
                  event(new HistoryForSentEmails($email,$details['order_number']));
               
                // print out response data
                // print $response->statusCode() . "\n";
                // print_r($response->headers());
                // print $response->body() . "\n";
               
                return $response->statusCode();
            } catch (Exception $e) {
                // something went wrong so display the error message
                echo 'Caught exception: ' . $e->getMessage() . "\n"; exit;
                return $e->getMessage();
                
            }
        }


    }
    /**
     * Get Unique Email id's from cart.
     *
     */


    public function getUniqueEmailId(Request $request)
    {
        $email = array();
        //   var_dump($email);
        $to_email = array();
        $email_unique = array();

        $value = $request->json()->all();
        // $c = 0;
        if (isset($value['order_items'])) {
            foreach ($value['order_items'] as $ord_val) {

                $arr = preg_split("/[-,|]+/", $ord_val['product_supplier']);
                array_push($email, trim($arr[2]));
            }
         
        }

        return $email ;
    }


    /**
     * Get Unique Supplier id's from cart.
     *
     */
    public function getUniqueSupplierId(Request $request){
       
        $supplier_ids = array();

        $value = $request->json()->all();
        if (isset($value['order_items'])) {
            foreach ($value['order_items'] as $ord_val) {
                $arr = preg_split("/[-,|]+/", $ord_val['product_supplier']);
                array_push($supplier_ids, trim($arr[0]));
            }
         
        }

        return $supplier_ids ;
    }


    public function updateBcmOrderItems($order_number,$order_date)
    {
        $data = BcmOrderItems::where('');
    }


    /**
     * Get Unique Supplier ids and Supplier Email id's from order array.
     *
     */
    public function getUniqueValues($orderData)
    {    
        $value = array();
        $i=0;
        foreach($orderData as $data){
            $value[$i]['email'] = trim($data['supplier_emailid']);
            $value[$i]['sid'] = trim($data['supplier_id']);
            $i++;
       } 
        return  $value;
       
    }


    
    /**
     *  Automatic Email sent to supplier when payment_status changes to paid.
     *
     */
    public function emailOnStatusChangedToPaid($orderNumber)
    {
          
            $orderData = $this->order->getOneOrderData($orderNumber);
            $values = $this->getUniqueValues($orderData);
            $uniquevalues = array_unique($values, SORT_REGULAR);

            if(count($orderData)>0){
               
                foreach($uniquevalues as $val){

                    $itemData = array();
                    foreach($orderData as $item) {

                        if(intval($val['sid']) == intval($item['supplier_id'])){

                          array_push( $itemData,$item);  

                        }else if($val['sid'] != $item['supplier_id']){
                            continue;
                        }
                     
                    }
                       $success = $this->sendEmailToSupplier($itemData, $cart=null, trim($val['email']), $ar=null); 
                   
                    if($success == 202){
                        $message =  1;
                    }
                    else{
                        $message = 0;
                    }
                   
                }
                return $message;
            }
        
      return false;
    }

   
}
                   