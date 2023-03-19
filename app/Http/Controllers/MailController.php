<?php

namespace App\Http\Controllers;

use App\Mail\longDelayMail;
use App\Mail\outOfStockMail;
use App\Mail\sendTrackingMail;
use App\Mail\WelcomeMail;
use App\Mail\emailSupplier;
use App\Mail\emailSupplierNDISOrder;
use App\Mail\emailSupplierChangeOrder;
use App\Mail\ndisFundReceivedEmail;
use App\Mail\emailSupplierOrderUpadte;
use App\Mail\emailSupplierTracking;
use App\Mail\emailSupplierETA;  

use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Support\Facades\Mail;
use App\Models\BcmOrder;
use App\Models\BcmOrderItems;
use App\Models\Supplier;
use App\Models\Shipping;
use App\Models\Courier;
use App\Repositories\ManagementPortal\AllOrderRepository;
use Exception;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class MailController extends Controller
{

    public function __construct(AllOrderRepository $order)
    {
        $this->order = $order;
    }
    
    public function emailCustomer ($orderNumber,Request $request){
        $data=$request->all();
        $message=$data["body"];
        $link=$data["link"];
        
        $order=BcmOrder::where('order_number',intval($orderNumber))->first();
        try{
            Mail::to('info@bettercaremarket.com.au')->send(new WelcomeMail($message,$order,$link));
        } catch(Exception $e){
           // dd($e->getMessage());
        }
			
            return back()->with('success',' successfully send an email to customer.');
           
        }


    /**
     * 
     * send  email  to customer informing product is out of stock
    */    
    public function outOfStockPage ($orderNumber, $sku = null, Request $request){
        $sku = explode(',',$sku);
        $name = array();
        for($i=0; $i<(count($sku)); $i++){
            $data = BcmOrderItems::select('item_name','item_sku')->where(['order_id'=>$orderNumber, 'item_sku'=>$sku[$i]])->first()->toarray();
            array_push($name,$data);
        }
        // print_r($data);
         //dd($name);
        //  exit;

        $orderData=BcmOrder::where('order_number',$orderNumber)->first()->toArray();
        
       return view('admin.mail.outOfStockPage',['orderData' => $orderData,'name'=>$name]);
        }

    public function outOfStockSend ($orderNumber,Request $request){
        $data=$request->all();
    
        $order=BcmOrder::
        where('order_number',intval($orderNumber))->first();
        
        try{
            Mail::mailer('maillingCustomer')->to('info@bettercaremarket.com.au')->send(new outOfStockMail($data,$order));
        } catch(Exception $e){
            echo $e; //exit;
            return back()->with('error', 'fail to send email, please try again');
        }
			
            return redirect(route('viewOrderDetails',['id'=>$orderNumber]))->with('success',' successfully send an email to customer.');
        
    }


    /**
     * 
     * send  email  to customer informing long delay
    */
    public function longDelayPage($orderNumber, $sku = null, Request $request){
        $sku = explode(',',$sku);
        $name = array();
        for($i=0; $i<(count($sku)); $i++){
            $data = BcmOrderItems::select('item_name','item_sku')->where(['order_id'=>$orderNumber, 'item_sku'=>$sku[$i]])->first()->toarray();
            array_push($name,$data);
        }
        // print_r($data);
         //dd($name);
        //  exit;
        $orderData = BcmOrder::where('order_number',$orderNumber)->first()->toArray();
        if(count($orderData)>0){

            return view('admin.mail.longDelayPage',['orderData' => $orderData, 'name'=>$name]);
        } 
        return redirect(route('viewOrderDetails',['id',$orderNumber]))->with('error','Please try again, there\'s no such a page ');


    }

    public function longDelaySend($orderNumber, Request $request){

        $data=$request->all();
        //dd($data);
        $order= BcmOrder::where('order_number', intval($orderNumber))->first();

        try{

            Mail::mailer('maillingCustomer')->to('info@bettercaremarket.com.au')->send(new longDelayMail($data,$order));

        } catch(Exception $e){
            echo $e; //exit;
            return back()->with('error','Failed to send email to customer. Please try again');
        }
        return redirect(route('viewOrderDetails',['id'=>$orderNumber]))->with('success',' successfully send an email to customer.');
    }


    /**
     * 
     * send  tracking details to customer 
    */

    public function sendTrackingEmailPage($orderNumber, $tracking_id=null){
        $orderData = BcmOrder::where('order_number',$orderNumber)->get()->toArray();
        $tracking_id = explode(',',$tracking_id);
        $trackingData = array();
        for($i=0; $i<(count($tracking_id)); $i++){
            $data = Shipping::where('id' , $tracking_id[$i])->first()->toArray();
            $link = Courier::where('id', $data['courier_company'])->pluck('link');
            $data['link'] = $link[0];
            array_push($trackingData,$data);
           
        }
  
       

        
        if(count($orderData)) return view('admin.mail.emailTracking',['orderData' => $orderData[0] , 'trackingData' => $trackingData]);
        return redirect(route('fetchAllOrders'))->with(['error','Can\'t find such a page. Please try again']);


    }
    
    
    public function emailTrackingInfo($orderNumber,Request $request){
        $data=$request->all();
        $tracking=[];
        // $keys=[];
        $values=[];
        $comments="";
        
        
        foreach($data as $key => $dataItem){
            if ($dataItem){
                if($key=="_token") continue;
                if($key == "Comments"){
                    $comments = $dataItem;
                    continue;
                }
                array_push($values,$dataItem);
                continue;
            }
            break;
        }
     ;
     
      
        // if(count($values)%2!=0) return back()->with('error','You didn\'t enter enough fields. Please try again');
        // for( $i=0; $i<(count($values)-1);$i+=2){

        //       $tracking[$values[$i]]=$values[$i+1];
        // }
        for( $i=0; $i<(count($values)-1);$i+=3){
          array_push($tracking,[$orderNumber,$values[$i],$values[$i+1],$values[$i+2]]);
              
        }
        

      


        $order= BcmOrder::where('order_number', intval($orderNumber))->first();
  
        try{

            // Mail::mailer('maillingCustomer')->to('info@bettercaremarket.com.au')->send(new sendTrackingMail($tracking,$order));
            Mail::mailer('maillingCustomer')->to($order->customer_email)->send(new sendTrackingMail($tracking,$order,$comments));

        } catch(Exception $e){
            return back()->with('error',$e->getMessage().'Failed to send email to customer. Please try again');
        }

        return redirect(route('viewOrderDetails',['id'=>$orderNumber]))->with('success',' successfully send an email to customer.');

    }

    /**
     * 
     * send manual email to supplier
    */
    public function emailSupplierPage($supplier_id)
    {
        $supplierData = Supplier::select('supplier_id','supplier_name','contact_person','phone_number','supplier_emailid')->where('supplier_id',$supplier_id)->distinct()->get()->toArray();
        if(count($supplierData)) return view('admin.mail.emailSupplierPage',['supplierData' => $supplierData[0]]);
        return redirect(route('getAllSuppliers'))->with(['error','Can\'t find such a page. Please try again']);
    }

    public function emailSupplier($supplier_id, Request $request)
    {
        $data = $request->all();
        $supplierData = Supplier::select('supplier_emailid' , 'supplier_name')->where('supplier_id',$supplier_id)->distinct()->first()->toArray();
        $supplier_name = $supplierData['supplier_name'];
        $supplier_emailid =  $supplierData['supplier_emailid'];
        //dd($supplierData);

        try{

             Mail::mailer('mailingSupplier')->to('info@bettercaremarket.com.au')->send(new emailSupplier($supplier_name,$data ) );
         
        } catch(Exception $e){
            echo $e; exit;
            return back()->with('error','Failed to send email to Supplier. Please try again');
        }
        return redirect(route('emailSupplierPage',['supplier_id'=>$supplier_id]))->with('success',' successfully send an email to supplier.');

    }

    public function getUniqueEmail($orderData)
    {
        $email = array();
        foreach($orderData as $data){
            $email[] = trim($data['supplier_emailid']);
       } 
        
        return  $email;
       
    }


    /**
     * 
     * send ndis email to supplier /not in use right now
    */
    public function emailSupplierNDISOrderPage($supplier_id)
    {       
        if(isset($supplier_id) ) return view('admin.mail.emailSupplierNDISOrderPage',['supplier_id' => $supplier_id ]);
        return back()->with('error','Can\'t find such a page. Please try again');   
    }

    public function getOneSupplierOrderData($orderNumber, Request $request){
     
        $supplier_id = $request->all()['supplier_id'];
        $orderData = $this->order->getOneSupplierOrderData($orderNumber, $supplier_id);
       // print_r($orderData);

        if( !empty($orderData)){

            $orderData = view('admin.mail.getOneSupplierOrderData', ['orderData'=>$orderData])->render();
            $r = array('status'=>1 , 'html'=>$orderData);
            return json_encode($r);
        }
        else{
            $r = array('status'=>0 , 'html'=>'');
            return json_encode($r);
            //return false ;
        } 
       
    }

    public function emailSupplierNDISOrder($supplier_id, Request $request){
       // dd($request->all());
        $data = $request->all();
        $items = $data['item'];
        $item = array();
      //  dd($items[0]);
        if(count($data) > 0 AND isset($data['_token']))
        {
            for( $i=0; $i<(count($items)-1);$i+=4){
                array_push($item , [$items[$i],$items[$i+1],$items[$i+2]]);
                    
              }
            //  dd($item);
            try{

                Mail::mailer('mailingSupplier')->to('info@bettercaremarket.com.au')->send(new emailSupplierNDISOrder($data,$item) );
            
            } catch(Exception $e){
                echo $e; 
                return back()->with('error','Failed to send email to Supplier. Please try again');
            }
            
            return redirect(route('emailSupplierNDISOrderPage',['supplier_id' => $supplier_id]))->with('success','Successfully send email to Supplier. ');
        }

        return redirect()->back()->with('error','Failed to send email to Supplier. Please try again');
    }

    /**
     * 
     * send  email to supplier inquiring order update
    */

    public function emailSupplierOrderUpdatePage($supplier_id, $orderNumber)
    {       
        if(isset($supplier_id) &&  isset($orderNumber) ){

            //checking order number for respective supplier
            $data = Supplier::where(['order_id' => $orderNumber, 'supplier_id' =>$supplier_id])->exists();
            if($data == true) return view('admin.mail.emailSupplierOrderUpdatePage',['supplier_id' => $supplier_id , 'orderNumber' =>$orderNumber ]);
        } 
        return back()->with('error','Can\'t find such a page. Please try again');   
    }

    public function emailSupplierOrderUpadte($supplier_id, Request $request){
        $data = $request->all();
        $supplierData = Supplier::select('supplier_emailid' , 'supplier_name')->where('supplier_id',$supplier_id)->distinct()->first()->toArray();
        $supplier_emailid =  $supplierData['supplier_emailid'];

        if(count($data)>0 AND isset($data['_token'])){
          
                try{

                    Mail::mailer('mailingSupplier')->to('info@bettercaremarket.com.au')->send(new emailSupplierOrderUpadte($data) );
                
                } catch(Exception $e){
                    echo $e; 
                    return back()->with('error','Failed to send email to Supplier. Please try again');
                }
                
                return redirect(route('emailSupplierOrderUpdatePage',['supplier_id' => $supplier_id, 'orderNumber'=>$data['orderNumber']] ))->with('success','Successfully send email to Supplier. ');

        }
        return redirect()->back()->with('error','Failed to send email to Supplier. Please try again');
    }


    /**
     * 
     * send  email to supplier requesting tracking details
    */

    public function emailSupplierTrackingPage($supplier_id, $orderNumber)
    {       
        if(isset($supplier_id) && isset($orderNumber) ){
            $data = Supplier::select('order_id','bcm_order.customer_first_name','bcm_order.customer_last_name')
                            ->leftjoin('bcm_order', 'bcm_order.order_number','=','supplier.order_id' )
                            ->where(['order_id' => $orderNumber, 'supplier_id' =>$supplier_id])->first()->toarray();
            return view('admin.mail.emailSupplierTrackingPage',['supplier_id' => $supplier_id, 'data' =>$data]);
        } 
        return back()->with('error','Can\'t find such a page. Please try again');   
    }

    public function emailSupplierTracking($supplier_id, Request $request){
        $data = $request->all();
        $supplierData = Supplier::select('supplier_emailid' , 'supplier_name')->where('supplier_id',$supplier_id)->distinct()->first()->toArray();
        $supplier_emailid =  $supplierData['supplier_emailid'];
         //dd($data);
        if(count($data)>0 AND isset($data['_token'])){
       
                try{

                    Mail::mailer('mailingSupplier')->to('info@bettercaremarket.com.au')->send(new emailSupplierTracking($data) );
                
                } catch(Exception $e){
                    echo $e;//  exit;
                    return back()->with('error','Failed to send email to Supplier. Please try again');
                }
                
                return redirect(route('emailSupplierTrackingPage',['supplier_id' => $supplier_id , 'orderNumber'=>$data['orderNumber']]))->with('success','Successfully send email to Supplier. ');

        }
        return redirect()->back()->with('error','Failed to send email to Supplier. Please try again');
    }


    /**
     * 
     * send  email to supplier requesting ETA details
    */
    public function emailSupplierETAPage($supplier_id)
    {       
        if(isset($supplier_id) && $supplier_id != null ) return view('admin.mail.emailSupplierETAPage',['supplier_id' => $supplier_id]);
        return back()->with('error','Can\'t find such a page. Please try again');   
    }

    public function emailSupplierETA($supplier_id, Request $request){

        $data = $request->all();
        $supplierData = Supplier::select('supplier_emailid' , 'supplier_name')->where('supplier_id',$supplier_id)->distinct()->first()->toArray();
        $supplier_emailid =  $supplierData['supplier_emailid'];

       if(count($data)>0 AND isset($data['_token'])){

            $sku = array_filter($data['product_sku']);
           // dd($sku);
            $valid_sku = array();
            for($i=0; $i<(count($sku)); $i++ ){
                if($checkOrderNo[$i] =  Supplier::where([ 'product_sku'=> $sku[$i] , 'supplier_id'=> $supplier_id ] )
                ->exists()){
                   array_push($valid_sku, $sku[$i]);
                }  
                else{
                    
                    $valid_sku= array();
                    
                    return redirect()->back()->with('error','You have entered an invalid product sku.');
                     break;
                }
            }   
       
            if(count($valid_sku)  >0 AND $valid_sku != null ){
              
                    try{
                        Mail::mailer('mailingSupplier')->to('info@bettercaremarket.com.au')->send(new emailSupplierETA($valid_sku) );
                    
                    } catch(Exception $e){
                        echo $e;  //exit;
                        return back()->with('error','Failed to send email to Supplier. Please try again');
                    }
                    
                    return redirect(route('emailSupplierETAPage',['supplier_id' => $supplier_id]))->with('success','Successfully send email to Supplier. ');
            }
             
           return redirect()->back()->with('error','You have entered an invalid product sku.');
       }
       return redirect()->back()->with('error','Failed to send email to Supplier. Please try again');
    }


    /**
     * 
     * send  email to supplier for order changes
    */
    public function emailSupplierChangeOrderPage($supplier_id, $orderNumber){

        $orderData = $this->order->getOneSupplierOrderData($orderNumber, $supplier_id);
       // dd($orderData);
        if(isset($supplier_id) && !empty($orderData) ) return view('admin.mail.emailSupplierChangeOrderPage',['supplier_id' => $supplier_id , 'orderData' =>$orderData ]);
        return back()->with('error','Can\'t find such a page. Please try again');   
    }

    public function emailSupplierChangeOrder($supplier_id, Request $request){
        $data = $request->all();
        $supplierData = Supplier::select('supplier_emailid' , 'supplier_name')->where('supplier_id',$supplier_id)->distinct()->first()->toArray();
        $supplier_emailid =  $supplierData['supplier_emailid'];
        $items = $data['item'];
        $item = array();
        
        if(count($data) > 0 AND isset($data['_token']))
        {
            for( $i=0; $i<(count($items)-1);$i+=4){
                array_push($item , [$items[$i],$items[$i+1],$items[$i+2]]);
                    
            }
            try{

                Mail::mailer('mailingSupplier')->to('info@bettercaremarket.com.au')->send(new emailSupplierChangeOrder($data,$item) );
            
            } catch(Exception $e){
                echo $e; 
                return back()->with('error','Failed to send email to Supplier. Please try again');
            }
            
            return redirect(route('emailSupplierChangeOrderPage',['supplier_id' => $supplier_id , 'orderNumber'=>$data['order_number']]))->with('success','Successfully send email to Supplier. ');
        }

        return redirect()->back()->with('error','Failed to send email to Supplier. Please try again');
    }

    /**
     * 
     * send  email  to ndis customer informing fund receivd from plan manager
    */
    public function ndisFundReceivedEmail($orderNumber, $orderData){
        $customer_email = $orderData['customer_email'];
        if($orderNumber!= '' &&  count($orderData)>0){
            try{
                Mail::mailer('maillingCustomer')->to('info@bettercaremarket.com.au')->send(new ndisFundReceivedEmail($orderNumber,$orderData) );
                return 1;
            
            } catch(Exception $e){
                return 0;
            }
        }
        return false;
        
    }


}
