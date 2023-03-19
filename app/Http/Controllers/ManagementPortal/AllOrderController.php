<?php

namespace App\Http\Controllers\ManagementPortal;

use App\Console\Commands\TrackingProgress;
use App\Http\Controllers\Controller;

use App\Http\Controllers\SendEmailSupplierController;
use Illuminate\Http\Request;

use App\Repositories\ManagementPortal\AllOrderRepository;
use App\Repositories\CommonRepository;

use App\Models\Shipping;
use App\Models\BcmOrderItems;
use App\Models\Ticketing;
use App\Models\BcmOrder;
use App\Models\Comment;
use App\Models\Supplier;
use App\Models\Courier;

use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Mpdf\Tag\Input;
use PhpParser\Node\Expr\AssignOp\Concat;

class AllOrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    

    public function __construct(AllOrderRepository $order, CommonRepository $common , SendEmailSupplierController $emailToSupplier) {
        $this->order = $order;
        $this->common = $common;
        $this->orderStatus=config('ndis.newOrderStatus1');
        $this->emailToSupplier = $emailToSupplier;

    }
    
    
    // Fetch all orders and tickets due today 
    //
    

    public function fetchAllOrders()
    
    {
        
        $overDue = Ticketing::whereDate('due_date', '<=', now()->format('Y-m-d'))
        ->where('status','!=','closed')->orderBy('created_at', 'desc')->get()->toArray();
        
        
            return View('admin.order.allOrder.all')
         
            ->with('alertArray',json_encode($overDue));
        
    }

     // filtering orders based on different criteria 

     public function filteredOrders(Request $request) {
        
        
        if(request()->ajax()) {
            
            $data = $this->order->fetchAllOrders();
           
            // start of customized_search time function 
            $order_status= ($request->has('order_status') && !is_null($request->query('order_status')))?intval($request->query('order_status')):null;
            $order_status_secondary= ($request->has('order_status_secondary') && !is_null($request->query('order_status_secondary')))?(intval($request->query('order_status_secondary'))-1):null;
            if($order_status && $order_status_secondary){
                if($order_status == 0){
                    $data = $data->whereNull('bcm_order.order_status');
                } else {
                    
                   
                    $data = $data->whereBetween('bcm_order.order_status',[$order_status,$order_status_secondary]);
               
                }
            } elseif($order_status){
                if($order_status == 0){
                    $data = $data->whereNull('bcm_order.order_status');
                } else {
                    $data = $data->where('bcm_order.order_status',$order_status);
                }

            }
            $search_from=(!is_null($request->query('start_date')))? $request->query('start_date'):('');
            $search_until=(!is_null($request->query('end_date')))? $request->query('end_date'):('');
            
            if($search_from && $search_until){
                $search_from = date('Y-m-d', strtotime($search_from));
                $search_until = date('Y-m-d', strtotime($search_until));
                $data=$data->where('bcm_order.order_date','>=', $search_from)->where('bcm_order.order_date','<=', $search_until);
            }elseif($search_from){
                $search_from = date('Y-m-d', strtotime($search_from));
                $data=$data->where('bcm_order.order_date','>=', $search_from);
            }elseif($search_until){
                $search_until = date('Y-m-d', strtotime($search_until));
                $data=$data->where('bcm_order.order_date','<=', $search_until);
            }
            //end of customized_search function


            //start of category search
            if($request->has('category') && !is_null($request->query('category'))){
                $category = $request->query('category');
                
                if ($category=='ndis'){
                    
                    $data->where('bcm_order.payment_option','ndis');
                
                } else{
                    $data->where('bcm_order.payment_option','!=','ndis');
                }
            }

            // start of supplier invoice search

            if($request->has('supplier_invoice') && !is_null($request->query('supplier_invoice'))){
                $supplier_invoice = $request->query('supplier_invoice');
                
                if ($supplier_invoice != null){
                    
                    $data = $data->where('supplier.invoice_number',$supplier_invoice);
                
                }

            }

            // return DataTables::of($data)
            
            $data=$data->get()->toArray();
           // print_r($data);
          // return  json_encode($data);
            return app('datatables')->of($data)
            ->editColumn('order_status', function ($row){
                switch ($row['order_status']) {
                    case 0: 
                        return 'Error';  
                    case 1: 
                        return 'Pending payment';  
                    case 2: 
                        return 'Paid';  
                    case 3: 
                        return 'Processed by BCM';
                    case 4: 
                        return 'Pending by supplier';  
                    case 5: 
                        return 'Processed by supplier';  
                    case 6: 
                        return 'Tracking code received'; 
                    case 7: 
                        return 'Delivered';
                    case 8: 
                        return 'Returned';
                    case 9: 
                        return 'On BackOrder';
                    case 10: 
                        return 'Completed';
                    case 11: 
                        return 'Refund';
                    default: 
                    return null;
 
                }
            })
            ->editColumn('order_date', function ($row){
                if ($row['order_date']) {
                    return date('Y-m-d',strtotime($row['order_date']));
                }
                return '';
            })
            ->editColumn('ndis_type', function($row){
                
                if ($row['ndis_type']) {
                    return CommonRepository::encrypt_decrypt($row['ndis_type'],'decrypt');
                }

                return 'non-ndis/self-managed';
                
            })

            ->addColumn('customer_name', function($row){
                return $row['customer_first_name'].' '.$row['customer_last_name'];
            })

            ->addColumn('shipping_address_name', function($row){
                return $row['shipping_address_first_name'].' '.$row['shipping_address_last_name'];
            })
            // ->addColumn('supplier_invoice', function($row){
            //     return $row['invoice_number'];
            // })
            ->addColumn('assign',function($row){
                // return $row['assigned_to'];

                if(!$row['assigned_to']){
                    return '0';
                }
                if ($row['assigned_to']=='finished') return '2';

                if ($row['assigned_to']!=request()->ip()){
                    return '1';}

                
                return '3';
            })
            ->addColumn('action', function($row) {
                
                //Hirarchy of order statuses
                $dropdowndata = '';
                    if($row['order_status'] >= 2){ 
                        $dropdowndata .= '<a class="dropdown-item" href="#" onclick="changeOrderStatus('.$row['order_number'].',2)" style="pointer-events: none; color:grey;" >Paid</a>';
                    }else{
                        $dropdowndata .= '<a class="dropdown-item" href="#" onclick="changeOrderStatus('.$row['order_number'].',2)" >Paid</a>';
                    }
                    if($row['order_status'] >= 3){ 
                        $dropdowndata .= '<a class="dropdown-item" href="#" onclick="changeOrderStatus('.$row['order_number'].',3)" style="pointer-events: none; color:grey;" >Processed by BCM</a>';
                    }else{
                        $dropdowndata .= '<a class="dropdown-item" href="#" onclick="changeOrderStatus('.$row['order_number'].',3)" >Processed by BCM</a>';
                    }
                    if($row['order_status'] >= 4){ 
                        $dropdowndata .= '<a class="dropdown-item" href="#" onclick="changeOrderStatus('.$row['order_number'].',4)" style="pointer-events: none; color:grey;">Pending by supplier</a>';
                    }else{
                        $dropdowndata .= '<a class="dropdown-item" href="#" onclick="changeOrderStatus('.$row['order_number'].',4)" >Pending by supplier</a>';
                    }
                    if($row['order_status'] >= 5){ 
                        $dropdowndata .= '<a class="dropdown-item" href="#" onclick="changeOrderStatus('.$row['order_number'].',5)" style="pointer-events: none; color:grey;">Processed by supplier</a>';
                    }else{
                        $dropdowndata .= '<a class="dropdown-item" href="#" onclick="changeOrderStatus('.$row['order_number'].',5)" >Processed by supplier</a>';
                    }
                    if($row['order_status'] >= 6){ 
                        $dropdowndata .= '<a class="dropdown-item" href="#" onclick="changeOrderStatus('.$row['order_number'].',6)" style="pointer-events: none; color:grey;">Tracking code received</a>';
                    }else{
                        $dropdowndata .='<a class="dropdown-item" href="#" onclick="changeOrderStatus('.$row['order_number'].',6)" >Tracking code received</a>';
                    }
                    if($row['order_status'] >= 7){ 
                        $dropdowndata .= '<a class="dropdown-item" href="#" onclick="changeOrderStatus('.$row['order_number'].',7)" style="pointer-events: none; color:grey;" >Delivered</a>';
                    }else{
                        $dropdowndata .='<a class="dropdown-item" href="#" onclick="changeOrderStatus('.$row['order_number'].',7)" >Delivered</a>';
                    }
                    if($row['order_status'] >= 8){ 
                        $dropdowndata .= '<a class="dropdown-item" href="#" onclick="changeOrderStatus('.$row['order_number'].',8)" style="pointer-events: none; color:grey;">Returned</a>';
                    }else{
                        $dropdowndata .= '<a class="dropdown-item" href="#" onclick="changeOrderStatus('.$row['order_number'].',8)">Returned</a>';
                    }
                    if($row['order_status'] >= 9){ 
                        $dropdowndata .= '<a class="dropdown-item" href="#" onclick="changeOrderStatus('.$row['order_number'].',9)" style="pointer-events: none; color:grey;">On BackOrder</a>';
                    }else{
                        $dropdowndata .= '<a class="dropdown-item" href="#" onclick="changeOrderStatus('.$row['order_number'].',9)" >On BackOrder</a>';
                    }
                    if($row['order_status'] >= 10){ 
                        $dropdowndata .= '<a class="dropdown-item" href="#" onclick="changeOrderStatus('.$row['order_number'].',10)" style="pointer-events: none; color:grey;">Completed</a>';
                    }else{
                        $dropdowndata .= '<a class="dropdown-item" href="#" onclick="changeOrderStatus('.$row['order_number'].',10)">Completed</a>';
                    }
                    if($row['order_status'] >= 11){ 
                        $dropdowndata .= '<a class="dropdown-item" href="#" onclick="changeOrderStatus('.$row['order_number'].',11)" style="pointer-events: none; color:grey;" >Refund</a>';
                    }else{
                        $dropdowndata .= '<a class="dropdown-item" href="#" onclick="changeOrderStatus('.$row['order_number'].',11)">Refund</a>';
                    }
                        

                  
                    
                    $workButton='<button class="btn btn-xs btn-info mr-2 py-0" onclick="workOnOrder('.$row['order_number'].')"> Work </button>';
                    $updateButton=' <div class="drop-right d-inline-block py-0">
        
                    <button class="btn dropdown-toggle btn-primary shadow-sm btn-xs mr-2 py-0" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Update Status
                    </button>
                    <div>
                   
                    <div class="dropdown-menu relative bottom-10" style="z-index:1000000;" aria-labelledby="dropdownMenuButton">
                        
                         '.$dropdowndata.'

                    </div>
                </div>';
                $viewButton= ' <a href="'. url('/admin/all_orders/view/'.$row['order_number']).'"><button type="button" class="btn btn-success shadow-sm btn-xs mr-2 py-0"
                data-toggle="tooltip" data-placement="left"
                >View
            </button></a>';
            if ($row['assigned_to']==request()->ip()){
                return $viewButton.$updateButton;
            }
            else{
                return $workButton.$viewButton.$updateButton;
            }
          
            })      
            ->make(true);

       }
    }


    // check order details
    //

    public function viewOrderDetails($id, Request $request) {
        $orderData = BcmOrder::find($id);
        if (!$orderData) {
            return redirect(route('fetchAllOrders'))->with('error', 'Fail to fetch order details! Please try again');;
        }
        $finish = ($request->ip() == $orderData->assigned_to)? True: False;
        $this->accessIP=$request->ip();

        return View('admin.order.allOrder.order_detail')->with('order',$orderData)->with(['orderId' => $id])->with(['finish'=>$finish]);
        ;
    }   


         
         
    /*
    *
     * Get Order Tracking information.
     *
     */

    public function getOrderShipping($id) {
        if(request()->ajax()) {

            $data = $this->order->getOrderShipping($id);




            return datatables()->of($data)
           
            // ->addColumn('check', function($row) {
            //    return '<input class="itemcheckbox" type="password" value="'.$row['id'].'"
            //    name="item[]" data="'.$row['tracking_number'].'" data-itemname="'.$row['item_name'].'"  >';
               
            // })
            // ->rawColumns(['check'])

            ->addColumn('action', function($row) {
                return '<a href="'. url('/admin/orders/tracking/edit/'.$row['id']).'"><button id="editShipping'.$row['id'].'" type="button"
                            class="btn btn-info shadow-sm btn--sm mr-2 acceptid"
                            data-toggle="tooltip" data-placement="left" >Edit
                        </button></a><input class="trackingcheckbox" type="checkbox" value="'.$row['id'].'" name="item[]" >';
            })

            ->make(true);

        }
        return View('admin.order.shipping_list')->with(['orderId' => $id]);
    }



     /*
     *
     * Get Order Items.
     *
     */
    public function getOrderProducts($id) {
       
            $data = $this->order->getOrderProducts($id);
         

           return datatables()->of($data)
           
           ->editColumn('supplier_order_date', function ($row){
                if ($row['supplier_order_date']) {
                    return date('Y-m-d',strtotime($row['supplier_order_date']));
                }
                return '';
            })
            ->addColumn('check', function($row) {
                if(isset($row['item_id'])){

                    return  '<input class="itemcheckbox" type="checkbox" value="'.$row['item_sku'].'" name="item[]" data="'.$row['item_name'].'" data-supplier-id="'.$row['supplier_id'].'" onclick="handleClick(this);" >';
                }

            })
            ->rawColumns(['check'])
             ->make(true);
    }


    /*
     *
     * Assign order to a specific Ip address
     *
     */

    public function assignOrderTo(Request $request){
        $requestData= $request->all();
        try{
            BcmOrder::where('order_number',$requestData['id'])->update(['assigned_to' => $request->ip()]);
            
        }
        catch(Exception $e){
            return false;
        }
        $request->session()->flash('success','You are responsible for this order now');
        return true;
     
    }



    /*
     *
     * finish working on one order
     *
     */

    public function finishWorkingOrder(Request $request){
        // dd($request->all());
        try{
            if(array_key_exists('orderId',$request->all())){
                $orderId=$request->all()['orderId'];
            }else{
                return $request->session()->flash('error', 'please send orderId');
            }
            // dd($orderId);
            BcmOrder::where('order_number',$orderId)->update(['assigned_to' => 'finished']);
        }catch(Exception $e){
            $request->session()->flash('error', $e->getMessage());
            return false;
        }
        $request->session()->flash('success', 'You have finished working on this order!');
        return true;

    }



     /*
     *
     * Update Order Status.
     *
     */
    public function updateOrderStatus(Request $request) {
        $result=$this->order->updateOrderStatus($request->all());
      
        if ($result) {
           
            if($result == 'true'){
                $message = ['status'=>'1','message'=>'Successfully update the status'];
                $request->session()->flash('success', 'Successfully update the status');
                return json_encode($message);
            }  
            else{
                return json_encode($result[0]);
            }              
        }
        $message = ['status'=>'0','message'=>'failed to update the order status'];
        return json_encode($message);
        
    }

    /*
      *
      * create Tracking Modal data
      *
      */

    public function createTrackingModalData(Request $request){
      
        $requestData = $request->all();
        $supName = Supplier::select('supplier_name')->where('supplier_id' , $requestData['SupplierId'][0])->where('order_id', $requestData['orderId'] )->first()->toarray();
        $data = '';
        $couriers = Courier::all();
    
        foreach ($requestData['item_name'] as $name){
            $data .= '<div class="mb-3 ">
                        <label for="itemName" class="form-label">Item Name</label>
                        <input type="text" class="form-control itemName" id="itemName" name="itemName[]"
                             value="'.$name.'">
                    </div>';
        }
        foreach ($requestData['product_sku'] as $sku){
            $data .= '<input type="hidden" class="form-control product_sku" id="product_sku" name="product_sku[]"
                value="'.$sku.'">';
        }
             
        $data .= '<div class="mb-3 ">
             <input type="hidden" class="form-control " id="SupplierId" name="SupplierId"
                value="'.$requestData['SupplierId'][0].'">
            <label for="Supplierid" class="form-label">Supplier Name</label>
            <input type="text" class="form-control"  
                 value="'.$supName['supplier_name'].'">
        </div>';
        
      
        $options = '';
        foreach ($couriers as $courier) {
            $options .= '<option value="' . $courier->id . '">' . $courier->name . '</option>';
        }
    
    
    $data .= '<div class="mb-3">
                  <label for="courierCompany" class="form-label">Courier Company</label>
                  <i class="text-red-400 pt-1">&#42;</i>
                  <select class="form-control" id="courierCompany" name="courierCompany" required>
                   
                      ' . $options . '
                  </select>
              </div>';
           
         
        return $data;
     }

     /*
      *
      * create Tracking record
      *
      */

    public function createTrackingRecord(Request $request) {
        if(request()->ajax()) {
            $data=$this->order->createTrackingRecord($request->all());
            if ($data) {
                $request->session()->flash('success',' successfully created a tracking record.');
                return true;
                //  return redirect()->back()->with('success',' successfully created a tracking record.');
            }
            $request->session()->flash('error','Error, failed to create a tracking record. Please try again');
            return false;
            // return redirect()->back()->with('error','Error, failed to create a tracking record. Please try again');
        }

    }



    /*
     *
     * Edit Order Tracking record.
     *
     */
    public function editOrderTracking(Request $request, $id = '') {
        $couriers = Courier::all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->order->editOrderTracking($request->all());
            if ($data) {
                return redirect(url('/admin/all_orders/view').'/'.$request->order_number)->with('success',' Successfully Updated Tracking information .');
            }
            return redirect(route('getOrders'))->with('error','Something went wrong!');
        }

        $orderTrackingData = Shipping::find(intval($id));
        if (!$orderTrackingData) {
            return redirect(route('getOrders'));
        }
    

        
        $options = '';
        $courierList='';

        foreach ($couriers as $courier) {
       $selected = ($courier->id == $orderTrackingData->courier_company) ? 'selected' : ''; 
   $options .= '<option value="' . $courier->id . '" ' . $selected . '>' . $courier->name . '</option>';
        }
    
    
    $courierList .= '<div class="mb-3">
                  <label for="courierCompany" class="form-label">Courier Company</label>
                  <i class="text-red-400 pt-1">&#42;</i>
                  <select class="form-control" id="courier_company" name="courier_company" required>
                   
                      ' . $options . '
                  </select>
              </div>';
              $orderTrackingData->couriersList = $courierList;
           
        return View('admin.order.allOrder.edit_tracking')->with('orderTracking',$orderTrackingData);
    }




     /*
      *
      * Edit Order Items.
      *
      */

    public function editOrderItems(Request $request, $id = '') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->order->editOrderItems($request->all());
            if ($data) {
                return redirect(url('/admin/all_orders/view').'/'.$request->order_number)->with('success',' Successfully Updated OrderItem .');
            }
            return redirect(route('getOrders'))->with('error','Something went wrong!');
        }

        $orderItemData = BcmOrderItems::where('id', $id)->first();
        if (!$orderItemData) {
            return redirect(route('getOrders'));
        }
        return View('admin.order.allOrder.edit_order_item')->with('orderItem',$orderItemData);
    }




    /*
     *
     * Create a ticket.
     *
     */
    public function createTicket(Request $request) {
        if(request()->ajax()) {
           
            $requestData= $request->all();
            if(array_key_exists('order_number',$requestData) && $requestData['order_number']  ){
                if(!is_numeric($requestData['order_number'])) {
                    $request->session()->flash('error','The order number does not exists. Please input valid order number');
                return false;
                } 
                $order=BcmOrder::where('order_number',intval( $requestData['order_number'] ))->get()->toArray();
                if (count($order)>0) {
                    $data=$this->order->createTicket($requestData);
                } else {
                 $request->session()->flash('error', 'The order number does not exists. Please input valid order number');
                return false;
                    // return redirect()->route('fetchAllOrders')->with('error', 'The order number does not exists. Please input valid order number');
                }
            } else{
                $data=$this->order->createTicket($requestData); 
            }
           
            
            if($data){
                $request->session()->flash('success','Successfully Created A Ticket!');
                return true;
                // return redirect()->route('fetchAllOrders')->with('success', 'Successfully Created A Ticket!');
            }
            $request->session()->flash('error', 'Fail to Create A Ticket! Please try again');
            return false;
            // return redirect()->route('fetchAllOrders')->with('error', 'Fail to Create A Ticket! Please try again');
           
        }

    }




    /*
     *
     * All ticket page.
     *
     */

    public function getTicketsPage() {
        
        return View('admin.ticket.view_ticket',['currentInterval' => Config::get('ndis.checkOrderProgressInterval')]);

    }

     /*
     *
     * one ticket .
     *
     */

    public function getOneTicket($ticketId){
        return View("admin.ticket.view_ticket")->with('ticketId',$ticketId);

    }


     /*
     *
     * get ticket Information .
     *
     */

    public function getTicketDetails($ticketId,Request $request){
        $ticket=Ticketing::where('id',$ticketId)->first();
       if ($ticket) return view('admin.ticket.view_one_ticket',['ticket'=>$ticket]);
       $request->session()->flash('error', 'Tickets or tasks not found');
       return false;
    //    return back()->with('error','Tickets or tasks not found');

    }

    /*
     *
     * get edit ticket page.
     *
     */

    public function editTicketPage($ticketId){
        try{
            $ticketData=Ticketing::where('id',$ticketId)->first();
            if ($ticketData->order_number){

                $order= BcmOrder::where('order_number',$ticketData->order_number)->get()->toArray();
            //    dd($order);
                if(count($order)>0 && array_key_exists('order_status',$order['0'])){
                    return view('admin.ticket.edit_ticket_page')->with('ticketData',$ticketData)->with('orderStatus',$order['0']['order_status']);
                }
                
                
            } 
            return view('admin.ticket.edit_ticket_page')->with('ticketData',$ticketData);
        } catch(Exception $e){
               return back()->with('error','There is no such an page. Please try again!');
        }
        
      

    }


    /*
     *
     * edit ticket request.
     *
     */

    public function editTicket($ticketId, Request $request){
        $requestData=$request->all();
        // dd($requestData);
        
        try{
            $ticket=Ticketing::where('id',$ticketId)->first();
            foreach($requestData as $key => $value){
                if(($value || $key=="notes") && $key != 'orderStatus') $ticket->{$key} = $value;
            }
            if(array_key_exists('orderStatus',$requestData) && $requestData['orderStatus']) {
                $order = BcmOrder::where('order_number',$ticket['order_number'])->first();
                $oldOrder = $order;

                $order->order_status = $requestData['orderStatus'];
                if(!$order->save())  return redirect(route('getTicketsPage'))->with('error','Something is wrong.Please try again ');
                if( $order->order_status) 
                {$oldStatus=$this->orderStatus[$oldOrder->order_status];}
                else{
                    $oldStatus='ERROR';
                }
                $comment='update order status from '.$oldStatus.' to '.$this->orderStatus[$requestData['orderStatus']];
                try{

                    Comment::create(['comment' => $comment,'order_number'=>$ticket['order_number']]);
                } catch(Exception $e){
                    $request->session()->flash('error',' failed to update the ticket status.');
            return true;
                }
                
            }
                
            if($ticket->save()){
            //     $request->session()->flash('success',' successfully updated ticket information!.');
            // return true;
            return back()->with('success',' successfully updated ticket information!');
            } 
            // return redirect(route('getTicketsPage'))->with('success','successfully updated ticket information!');
        }catch(Exception $e){
            return redirect(route('getTicketsPage'))->with('error','Something is wrong.Please try again '.$e->getMessage());
        }
            
        

    }


/*
     *
     * get all tickets Information .
     *
     */

    public function getAllTickets(Request $request) {
       
      
        if(request()->ajax()) {

            
          
            $data = $this->order->getAllTickets($request->all());
           
                return datatables()->of($data)
               ->editColumn('created_at',function($row){
                    return date("Y-m-d", strtotime($row['created_at']));
                })
                ->addColumn('id',function($row){
                    $type=$row['type'];
                    if(!$type || $type=='0'){
                           return null;
                    }
                   elseif($type == '1'){
                        return "TA".$row['id'];
  
                    } elseif($type == '2'){
                        return "TI".$row['id'];

                    }
                  
                })
                ->addColumn('action', function($row) {
                    if($row['order_number']){
                        $url = route('viewOrderDetails', ['id' => $row['order_number']]);
                        $viewOrder='<button class="btn btn-secondary mr-1 btn-xs mr-1"> <a href="'.$url.'">View Order</a> </button>';
                    }
                    $viewTicketButton='<button class="btn btn-xs btn-warning mr-1"><a href='.route('getTicketDetails',['ticketId'=>$row['id']]).'>View Details</a></button>';
                    $editTicketButton='<button class="btn btn-xs btn-success mr-1"><a href='.route('editTicketPage',['ticketId'=>$row['id']]).'>edit</a></button>';
                    $editTicketButton='<a href='.route('editTicketPage',['ticketId'=>$row['id']]).'><button class="btn btn-xs btn-success mr-1">edit</button></a>';
                    $updateButton='<div class="dropdown d-inline-block mr-1">
                    <button class="btn dropdown-toggle btn-primary shadow-sm btn-xs" type="button" id="dropdownMenuButtonEdit" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        edit status 
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonEdit">
                        <button class="dropdown-item"  onclick="changeTicketStatus('.$row['id'].',\'processing\')">processing</button>
                        <button class="dropdown-item"  onclick="changeTicketStatus('.$row['id'].',\'open\')">open</button>
                        <button class="dropdown-item"  onclick="changeTicketStatus('.$row['id'].',\'closed\')">closed</button>
       
                    </div>
                </div>';
               
                return $row['order_number']? $viewOrder.$updateButton.$viewTicketButton.$editTicketButton:$updateButton.$viewTicketButton.$editTicketButton;

                })->make(true);
            
           
        }
    }

    public function updateTicketStatus(Request $request) {
        $result= $this->order->updateTicketStatus($request->all());
        if($result){
           $request->session()->flash('success',' update the ticket status successfully.');
            return true;
        }else{
            $request->session()->flash('error',' failed to update status.');
            return false;
        }
    }

    //comment
    public function getCommentsPage(Request $request) {
        if (request()->ajax()){
            $data = $this->order->getOrderComments($request->all());
                return datatables()->of($data)
                ->editColumn('created_at',function($row){
                    return date("d/m/Y H:i:s",strtotime($row['created_at']));
                })
                ->make(true);      

        } else{

            return null;
        }
        

    }

     /**
     * Create a order comment.
     *
     */
    public function createOrderComment(Request $request) {
        if(request()->ajax()) {
            $data=$this->order->createOrderComment($request->all());
            
            if ($data) {
                $request->session()->flash('success',' successfully created a comment.');
                return true;
                // return back()->with('success',' successfully created a comment.');
            }
            $request->session()->flash('error',' failed to creat a comment.');
            return false;
                // return back()->with('error',' failed to creat a comment.');
        }

    }


    /**
     * Get Email logs
     * 
     */

     public function getEmailLogsPage($orderNumber){
         if (request()->ajax()){
            $data = $this->order->getEmailLogsPage($orderNumber);
                return datatables()->of($data)
                ->editColumn('emaildate',function($row){
                    return date("d/m/Y H:i:s",strtotime($row['email_sent_date']));
                })
                ->make(true);          
        } else{
            return null;
        }

     }
    




}