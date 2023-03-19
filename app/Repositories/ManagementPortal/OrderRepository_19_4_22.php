<?php 
namespace App\Repositories\ManagementPortal;

use Illuminate\Http\Response;
use App\Repositories\CommonRepository;
use App\Repositories\NdisInternalApiRepository;
use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\AuditChangeLog;
use Illuminate\Support\Facades\Auth;
use App\Repositories\NdisExternalApiRepository;
use App\Models\NdisPaymentRequest;

class OrderRepository
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

    /**
     * Get All Orders.
     *
     */
    public function getAllOrders() {
        $ndis_service_booking_table = 'ndis_service_booking';
        // $plan_option = $this->common->encrypt_decrypt(config('ndis.plan_management_option.ndia_managed'));
        $plan_option = array( $this->common->encrypt_decrypt(config('ndis.plan_management_option.ndia_managed')) ,  $this->common->encrypt_decrypt('NDIS-managed') ) ;
        $ordersData = Orders::select('orders.id as id','order_number','order_date','order_status','customer_first_name','customer_last_name', 'order_total','service_booking_id','orders.response','shipping_total','gst_total')
                ->leftjoin($ndis_service_booking_table.' as sb','orders.id', '=', 'sb.orders_id')
                // ->where('orders.ndis_plan_management_option',$plan_option)
                ->wherein('orders.ndis_plan_management_option',$plan_option)
                ->orderBy('orders.order_date','DESC')->get()->toArray();
        return $ordersData;
    }

    /**
     * Get All Orders.
     *
     */
    public function getPlanManagedOrders() {
        $plan_option = $this->common->encrypt_decrypt(config('ndis.plan_management_option.plan_managed'));
        $ordersData = Orders::select('orders.id as id','order_number','order_date','order_status','customer_first_name','customer_last_name', 'order_total','orders.response','shipping_total','gst_total')
                ->where('orders.ndis_plan_management_option',$plan_option)
                ->orderBy('orders.order_date','DESC')->get()->toArray();
        return $ordersData;
    }

	/**
     * Get Order Items.
     *
     */
    public function getOrderItems($id) {
        $ndis_payment_request_table = 'ndis_payment_request';
        $order_items_table = 'order_items';
        $ordersData = Orders::select('orders.id as order_id','order_number','order_status','ndis_participant_number','oi.id as item_id','item_name','item_quantity','item_price','np.id as payment_id','np.status','claim_number','oi.response','oi.product_category_item')
            ->leftjoin($order_items_table.' as oi','orders.id', '=', 'oi.orders_id')
            ->leftjoin($ndis_payment_request_table.' as np','oi.id', '=', 'np.order_item_id')
            ->where('orders.id',$id)->get()->toArray();
        return $ordersData;
    }

    /**
     * Edit Order.
     *
     */
    public function editOrder($requestData) {
       $order = Orders::where('id',$requestData['id'])->first();
       if ($order) {
            $order->ndis_participant_first_name = $this->common->encrypt_decrypt($requestData['ndis_participant_first_name']);
            $order->ndis_participant_last_name = $this->common->encrypt_decrypt($requestData['ndis_participant_last_name']);
            $order->ndis_participant_number = $this->common->encrypt_decrypt($requestData['ndis_participant_number']);
            $order->ndis_participant_date_of_birth = $requestData['ndis_participant_date_of_birth'];
            if ($order->save()) {
               return true;
            }
        }
        return false;
    }

    /**
     * Edit Order Item.
     *
     */
    public function editOrderItem($requestData) {
       $order = OrderItems::where('id',$requestData['id'])->first();
       if ($order) {
            $order->product_category = $requestData['product_category'];
            $order->product_category_item = $requestData['product_category_item'];
            if ($order->save()) {
               return true;
            }
        }
        return false;
    }

    /**
     * Update Order Status.
     *
     */
    public function updateOrderStatus($requestData) {
        $order = Orders::where('id',$requestData['id'])->first();
        if ($order) {
            $order->order_status = 3;
            if ($order->save()) {
               return true;
            }
        }
        return false;
    }

    /**
     * Resubmit Order.
     *
     */
    public function resubmitOrder($reqData) {
        $orders = Orders::find($reqData['id']);
        if ($orders) {
            $orderId = $orders->id;
            $requestData = $orders->select('order_number','ndis_participant_number','ndis_participant_last_name','ndis_participant_date_of_birth','product_category','shipping_total','gst_total')->where('id',$reqData['id'])->first()->toArray();
            $requestData['ndis_participant_number'] = $this->common->encrypt_decrypt($requestData['ndis_participant_number'],'decrypt');
            $requestData['ndis_participant_last_name'] = $this->common->encrypt_decrypt($requestData['ndis_participant_last_name'],'decrypt');

            $requestData['order_items'] = $orders->orderitems()->select('item_name','item_quantity','item_price')->orderBy('id')->get()->toArray();
            // submit order to ndis
            $participatePlanId = $this->ndisInternal->getNdisPlan($requestData);
            if ($participatePlanId) {
                $serviceBooking = $this->ndisInternal->serviceBook($requestData, $participatePlanId, $orderId);
                if ($serviceBooking) {
                    if (isset($serviceBooking['service_booking_id']) && $serviceBooking['service_booking_id']) {
                        $ndisServiceBookId = $this->ndisInternal->internalServiceBook($serviceBooking, $orderId);

                        if (isset($serviceBooking['product_items']) && $serviceBooking['product_items']) {
                            foreach ($serviceBooking['product_items'] as $prodVal) {

                                $requestData['product_category_item'] = $prodVal['product_category_item'];
                                $requestData['quantity']       = $prodVal['quantity'];
                                $requestData['claimed_amount'] = $prodVal['per_unit_price'];
                                $requestData['order_item_id'] = $prodVal['order_item_id'];

                                $paymentCreate = $this->ndisInternal->createPayment($requestData, $orderId, $serviceBooking['service_booking_id']);
                                if ($paymentCreate) {
                                    $createPaymentInternal = $this->ndisInternal->internalCreatePayment($paymentCreate, $orderId, $ndisServiceBookId, $prodVal['order_item_id']);
                                }
                                if (isset($paymentCreate['claim_status']) && $paymentCreate['claim_status']) {
                                    $orderStatus = true;
                                }
                            }
                        }
                    }
                }
            }
            if (isset($orderStatus)) {
                $orderData = Orders::where('id',$orderId)->first();
                if ($orderData) {
                    $orderData->order_status = config('ndis.orderStatus.Resubmited');
                    $orderData->save();
                }
                $data = ['order_status' => 'Resubmited'];
                return $data;
            } else {
                $orderData = Orders::where('id',$orderId)->first();
                if ($orderData) {
                    $orderData->order_status = config('ndis.orderStatus.Error');
                    $orderData->save();
                }
                return ['order_status' => 'Error'];
            }
        }
        return ['order_status' => 'Error'];
    }

     /**
     * Audit Change Log.
     *
     */
    public function auditChangeLog($requestData) {
        $auditChangeLog = new AuditChangeLog();
        $auditChangeLog->page_id = $requestData['page_id'];
        $auditChangeLog->action = $requestData['action'];
        $auditChangeLog->created_user_id = Auth::user()->id;
        $auditChangeLog->orders_id = $requestData['orders_id'];
        $auditChangeLog->save();
    }

    /**
     * Update Order Item Status Cron.
     *
     */
    public function updateOrderItemStatusCron() {
        $ndis_payment_request_table = 'ndis_payment_request';
        $order_items_table = 'order_items';
        $orderData = Orders::select('ndis_participant_number','np.id as payment_id','np.status','claim_number')
            ->join($ndis_payment_request_table.' as np','orders.id', '=', 'np.orders_id')
            ->where('np.status',4)
            ->get()->toArray();
        if ($orderData) {
            foreach ($orderData as $ordValue) {
                if (isset($ordValue['claim_number']) && $ordValue['claim_number']) {
                    $request['participant']  = $this->common->encrypt_decrypt($ordValue['ndis_participant_number'],'decrypt');
                    $request['claim_number'] = $ordValue['claim_number'];
                    $getPaymentRequest = $this->ndisExternal->getPaymentDetails($request);
                    if (isset($getPaymentRequest['result']) && $getPaymentRequest['result']) {
                        $responseArray = json_decode($getPaymentRequest['result'],true);
                        if (isset($responseArray['result']) && $responseArray['result']) {
                            if (isset($responseArray['result']['claim_status']) && $responseArray['result']['claim_status']) {
                                $paymentRequestData = NdisPaymentRequest::where('id',$ordValue['payment_id'])->first();
                                if ($paymentRequestData) {
                                    $paymentRequestData->status = $responseArray['result']['claim_status'];
                                    $paymentRequestData->save();
                                }
                            }
                        }
                    }
                }
            }
        }
        return true;
    }
}