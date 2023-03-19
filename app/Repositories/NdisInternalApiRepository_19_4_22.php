<?php

namespace App\Repositories;

use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\NdisPaymentRequest;
use App\Models\NdisServiceBooking;
use App\Models\ProductCategoryItems;
use Illuminate\Http\Response;
use App\Repositories\CommonRepository;
use App\Repositories\NdisAuthenticationRepository;
use App\Repositories\NdisExternalApiRepository;
use App\Services\Api;
use Exception;
use PDF;
use App\Services\CustomPDF;

class NdisInternalApiRepository
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CommonRepository $common, NdisAuthenticationRepository $ndisAuthentication, NdisExternalApiRepository $ndisExternal)
    {
        $this->common = $common;
        $this->ndisAuthentication = $ndisAuthentication;
        $this->ndisExternal = $ndisExternal;
    }

    /**
     * Submit Order.
     *
     */
    public function submitOrder($requestData)
    {
        $orderObj = Orders::where('order_number', $requestData['order_number'])->first();
        if ($orderObj) {
            return 'OrderExists';
        }
        $orderId = $this->saveData($requestData);
        if ($orderId) {
            if ($requestData['ndis_plan_management_option'] == config('ndis.plan_management_option.plan_managed')) {

                $send = $this->sendEmailToPlanManager($requestData);
                $orderData = Orders::where('id', $orderId)->first();
                if ($orderData) {
                    $orderData->order_status = config('ndis.orderStatus.Submited');
                    $orderData->save();
                }
                $data = ['order_status' => 'Submited'];
                return $data;
            }
            $participatePlanId = $this->getNdisPlan($requestData);
            if ($participatePlanId) {
                $serviceBooking = $this->serviceBook($requestData, $participatePlanId, $orderId);
                if ($serviceBooking) {
                    if (isset($serviceBooking['service_booking_id']) && $serviceBooking['service_booking_id']) {
                        $ndisServiceBookId = $this->internalServiceBook($serviceBooking, $orderId);

                        if (isset($serviceBooking['product_items']) && $serviceBooking['product_items']) {
                            foreach ($serviceBooking['product_items'] as $prodVal) {
                                $requestData['product_category'] = $prodVal['product_category'];
                                $requestData['product_category_item'] = $prodVal['product_category_item'];
                                $requestData['quantity']       = $prodVal['quantity'];
                                $requestData['claimed_amount'] = $prodVal['per_unit_price'];
                                $requestData['order_item_id'] = $prodVal['order_item_id'];

                                $paymentCreate = $this->createPayment($requestData, $orderId, $serviceBooking['service_booking_id']);
                                if ($paymentCreate) {
                                    $createPaymentInternal = $this->internalCreatePayment($paymentCreate, $orderId, $ndisServiceBookId, $prodVal['order_item_id']);
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
                $orderData = Orders::where('id', $orderId)->first();
                if ($orderData) {
                    $orderData->order_status = config('ndis.orderStatus.Submited');
                    $orderData->save();
                }
                $data = ['order_status' => 'Submited'];
                return $data;
            } else {
                $orderData = Orders::where('id', $orderId)->first();
                if ($orderData) {
                    $orderData->order_status = config('ndis.orderStatus.Error');
                    $orderData->save();
                }
                return false;
            }
        }
        return false;
    }

    /**
     * Send Email to Plan Manager.
     *
     */
    public function sendEmailToPlanManager($requestData)
    {
        $email                              = $requestData['invoice_email_address'];
        $details['invoice_email_address']   = $requestData['invoice_email_address'];
        $details['plan_manager_name']       = $requestData['plan_manager_name'];
        $details['bettercarendis_email']    = config('ndis.bettercare_email');
        $details['order_number']            = $requestData['order_number'];
        $details['order_date']              = $requestData['order_date'];
        $details['ndis_participant_name']   = $requestData['ndis_participant_first_name'] . ' ' . $requestData['ndis_participant_last_name'];
        $details['ndis_participant_number'] = $requestData['ndis_participant_number'];
        $details['ndis_participant_date_of_birth'] = $requestData['ndis_participant_date_of_birth'];
        $details['invoice_no']              = $requestData['invoice_no'];
        $details['registration_no']         = config('ndis.payment_invoice.ndis_registration_no');
        $details['account_name']            = config('ndis.payment_invoice.accountName');
        $details['bsb']                     = config('ndis.payment_invoice.bsb');
        $details['account_no']              = config('ndis.payment_invoice.accountNo');
        $details['website']                 = config('ndis.payment_invoice.website');
        $details['order_total']             = $requestData['order_total'];

        $details['product_total'] = $details['gst_total'] = $details['shipping_total'] = $details['total_ex_tax'] = '';
        if (isset($requestData['product_total'])) {
            $details['product_total'] = $requestData['product_total'];
        }
        if (isset($requestData['gst_total'])) {
            $details['gst_total'] = $requestData['gst_total'];
        }
        if (isset($requestData['shipping_total'])) {
            $details['shipping_total'] = $requestData['shipping_total'];
        }
        if (isset($requestData['total_ex_tax'])) {
            $details['total_ex_tax'] = $requestData['total_ex_tax'];
        }
        $details['product_items'] = $requestData['order_items'];

        $data = [
            'bettercarendis_email'  => $details['bettercarendis_email'],
            'website'               => $details['website'],
            'registration_no'       => $details['registration_no'],
            'order_number' => $details['order_number'],
            'order_date' => $details['order_date'],
            'invoice_no' => $details['invoice_no'],
            'plan_manager_name' => $details['plan_manager_name'],
            'invoice_email_address' => $details['invoice_email_address'],
            'ndis_participant_name' => $details['ndis_participant_name'],
            'ndis_participant_number' => $details['ndis_participant_number'],
            'ndis_participant_date_of_birth' => $details['ndis_participant_date_of_birth'],
            'account_name' => $details['account_name'],
            'bsb' => $details['bsb'],
            'account_no' => $details['account_no'],
            'product_items' => $details['product_items'],
            'product_total' => $details['product_total'],
            'shipping_total' => $details['shipping_total'],
            'total_ex_tax' => $details['total_ex_tax'],
            'gst_total' => $details['gst_total'],
            'order_total' => $details['order_total'],
            'billing_address_street' => $requestData['billing_address_street'],
            'billing_address_city' => $requestData['billing_address_city'],
            'billing_address_state' => $requestData['billing_address_state'],
            'billing_address_post_code' => $requestData['billing_address_post_code'],
        ];

        $to       = $email;
        $cc       = config('ndis.email.cc_user_email');
        $from     = config('ndis.email.from_email');
        $subject  = 'Tax Invoice';
        $body     = view('order_invoice')
            ->with($data)->render();

        $view = \View::make('invoice', $data);
        $html_content = $view->render();


        PDF::AddPage();
        PDF::setFooterCallback(function ($pdf) {
            // Position at 15 mm from bottom
            $pdf->SetY(-13);
            // Set font
            $pdf->SetFont('helvetica', '', 8);
            $style = array('width' => 1.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 184, 169));

            $pdf->Line(10, 282, 200, 282, $style);

            // Page number
            $footertext = '<p style="width: 100%;text-align: center;font-size: 14px;">63 Christie Street, St. Leonards, 2065, New South Wales - <b>ABN: 96631530893</b></p>';

            // $pdf->writeHTMLCell(0, 0, '', '', $footertext, 0, 0, 0, true, '', true);
            $pdf->writeHTML($footertext, true, false, false, false, '');
        });
        PDF::writeHTML($html_content, true, false, false, false, '');
        $fileatt = PDF::Output(storage_path() . '/invoice_' . $details['invoice_no'] . '.pdf', 'F');
        $attachment = storage_path() . '/invoice_' . $details['invoice_no'] . '.pdf';

        try {
            $send = $this->common->sendEmail($to, $from, $subject, $body, $attachment, $cc, $details);
            unlink(storage_path() . '/invoice_' . $details['invoice_no'] . '.pdf');
            /*\Mail::send('order_invoice', $details, function ($message) use ($email) {
                $message->to($email)->subject('Tax Invoice');
            });*/
        } catch (\Exception $exception) {
            \Log::info($exception->getMessage());
        }
    }

    /**
     * Update order status.
     *
     */
    public function updateOrderStatus($requestData)
    {
        $ndis_payment_request_table = 'ndis_payment_request';
        $order_items_table = 'order_items';
        $ordersData = Orders::select('orders.id as order_id', 'order_number', 'order_status', 'ndis_participant_number', 'oi.id as item_id', 'item_name', 'item_quantity', 'item_price', 'np.id as payment_id', 'np.status', 'claim_number')
            ->leftjoin($order_items_table . ' as oi', 'orders.id', '=', 'oi.orders_id')
            ->leftjoin($ndis_payment_request_table . ' as np', 'oi.id', '=', 'np.order_item_id')
            ->where('order_number', $requestData['order_number'])->get()->toArray();
        if ($ordersData) {
            foreach ($ordersData as $key => $ordValue) {
                $data['order_number'] =  $ordValue['order_number'];

                $item_data['item_name']    =  $ordValue['item_name'];
                $item_data['item_quantity'] =  $ordValue['item_quantity'];
                $item_data['item_price']   =  $ordValue['item_price'];
                $item_data['item_status']  =  '';
                if (isset($ordValue['claim_number']) && $ordValue['claim_number']) {
                    $request['participant']  = $this->common->encrypt_decrypt($ordValue['ndis_participant_number'], 'decrypt');
                    $request['claim_number'] = $ordValue['claim_number'];
                    $getPaymentRequest = $this->ndisExternal->getPaymentDetails($request);
                    if (isset($getPaymentRequest['result']) && $getPaymentRequest['result']) {
                        $responseArray = json_decode($getPaymentRequest['result'], true);
                        if (isset($responseArray['result']) && $responseArray['result']) {
                            if (isset($responseArray['result']['claim_status']) && $responseArray['result']['claim_status']) {
                                $itemStatus = $responseArray['result']['claim_status'];
                                $paymentRequestData = NdisPaymentRequest::where('id', $ordValue['payment_id'])->first();
                                if ($paymentRequestData) {
                                    $paymentRequestData->status = $responseArray['result']['claim_status'];
                                    $paymentRequestData->save();
                                }
                                $item_data['item_status']  =  config('ndis.claimStatus.' . $itemStatus);
                                $item_data['claimed_amount'] = $responseArray['result']['claimed_amount'];
                                $item_data['product_category'] = $responseArray['result']['product_category'];
                                $item_data['product_category_item'] = $responseArray['result']['product_category_item'];
                                $item_data['product_description'] = $responseArray['result']['product_description'];
                                $item_data['invoice_number'] = $responseArray['result']['invoice_number'];
                            }
                        }
                    }
                }
                $data['order_items'][] = $item_data;
            }
            return $data;
        }
        return false;
    }

    /**
     * Save Data.
     *
     */
    public function saveData($requestData)
    {
        $orderObj = new Orders();
        return $this->saveOrderData($orderObj, $requestData);
    }

    /**
     * Save Order Data.
     *
     */
    public function saveOrderData($orderObj, $requestData)
    {
        $orderObj->order_number                = $requestData['order_number'];
        $orderObj->ndis_participant_first_name = $this->common->encrypt_decrypt($requestData['ndis_participant_first_name'], 'encrypt');
        $orderObj->ndis_participant_last_name  = $this->common->encrypt_decrypt($requestData['ndis_participant_last_name'], 'encrypt');
        $orderObj->ndis_participant_number     = $this->common->encrypt_decrypt($requestData['ndis_participant_number'], 'encrypt');
        $orderObj->ndis_participant_date_of_birth = $requestData['ndis_participant_date_of_birth'];
        if (isset($requestData['product_category']) && $requestData['product_category']) {
            $orderObj->product_category = $requestData['product_category'];
        }
        if (isset($requestData['order_date']) && $requestData['order_date']) {
            $orderObj->order_date = $requestData['order_date'];
        }
        if (isset($requestData['order_discount']) && $requestData['order_discount']) {
            $orderObj->order_discount = $requestData['order_discount'];
        }
        if (isset($requestData['shipping_total']) && $requestData['shipping_total']) {
            $orderObj->shipping_total = $requestData['shipping_total'];
        }
        if (isset($requestData['order_total']) && $requestData['order_total']) {
            $orderObj->order_total = $requestData['order_total'];
        }
        if (isset($requestData['gst_total']) && $requestData['gst_total']) {
            $orderObj->gst_total = $requestData['gst_total'];
        }
        if (isset($requestData['order_gst_status']) && $requestData['order_gst_status']) {
            $orderObj->order_gst_status = $requestData['order_gst_status'];
        }
        if (isset($requestData['customer_first_name']) && $requestData['customer_first_name']) {
            $orderObj->customer_first_name = $this->common->encrypt_decrypt($requestData['customer_first_name'], 'encrypt');
        }
        if (isset($requestData['customer_last_name']) && $requestData['customer_last_name']) {
            $orderObj->customer_last_name = $this->common->encrypt_decrypt($requestData['customer_last_name'], 'encrypt');
        }
        if (isset($requestData['billing_address_street'])) {
            $orderObj->billing_address_street = $requestData['billing_address_street'];
        }
        if (isset($requestData['billing_address_city']) && $requestData['billing_address_city']) {
            $orderObj->billing_address_city = $requestData['billing_address_city'];
        }
        if (isset($requestData['billing_address_state']) && $requestData['billing_address_state']) {
            $orderObj->billing_address_state = $requestData['billing_address_state'];
        }
        if (isset($requestData['billing_address_post_code']) && $requestData['billing_address_post_code']) {
            $orderObj->billing_address_post_code = $requestData['billing_address_post_code'];
        }
        if (isset($requestData['shipping_address_street'])) {
            $orderObj->shipping_address_street = $requestData['shipping_address_street'];
        }
        if (isset($requestData['shipping_address_city']) && $requestData['shipping_address_city']) {
            $orderObj->shipping_address_city = $requestData['shipping_address_city'];
        }
        if (isset($requestData['shipping_address_state']) && $requestData['shipping_address_state']) {
            $orderObj->shipping_address_state = $requestData['shipping_address_state'];
        }
        if (isset($requestData['shipping_address_post_code'])) {
            $orderObj->shipping_address_post_code = $requestData['shipping_address_post_code'];
        }
        if (isset($requestData['contact_phone_number']) && $requestData['contact_phone_number']) {
            $orderObj->contact_phone_number = $this->common->encrypt_decrypt($requestData['contact_phone_number'], 'encrypt');
        }

        if (isset($requestData['ndis_plan_management_option']) && $requestData['ndis_plan_management_option']) {
            $orderObj->ndis_plan_management_option = $this->common->encrypt_decrypt($requestData['ndis_plan_management_option'], 'encrypt');
        }
        if (isset($requestData['ndis_plan_start_date']) && $requestData['ndis_plan_start_date']) {
            $orderObj->ndis_plan_start_date = $requestData['ndis_plan_start_date'];
        }
        if (isset($requestData['ndis_plan_end_date']) && $requestData['ndis_plan_end_date']) {
            $orderObj->ndis_plan_end_date = $requestData['ndis_plan_end_date'];
        }
        if (isset($requestData['plan_manager_name']) && $requestData['plan_manager_name']) {
            $orderObj->plan_manager_name = $this->common->encrypt_decrypt($requestData['plan_manager_name'], 'encrypt');
        }
        if (isset($requestData['invoice_email_address']) && $requestData['invoice_email_address']) {
            $orderObj->invoice_email_address = $this->common->encrypt_decrypt($requestData['invoice_email_address'], 'encrypt');
        }
        if (isset($requestData['parent_carer_status']) && $requestData['parent_carer_status']) {
            $orderObj->parent_carer_status = $requestData['parent_carer_status'];
        }
        if (isset($requestData['parent_carer_name']) && $requestData['parent_carer_name']) {
            $orderObj->parent_carer_name = $this->common->encrypt_decrypt($requestData['parent_carer_name'], 'encrypt');
        }
        if (isset($requestData['parent_carer_email']) && $requestData['parent_carer_email']) {
            $orderObj->parent_carer_email = $this->common->encrypt_decrypt($requestData['parent_carer_email'], 'encrypt');
        }
        if (isset($requestData['parent_carer_phone']) && $requestData['parent_carer_phone']) {
            $orderObj->parent_carer_phone = $this->common->encrypt_decrypt($requestData['parent_carer_phone'], 'encrypt');
        }
        if (isset($requestData['parent_carer_relationship']) && $requestData['parent_carer_relationship']) {
            $orderObj->parent_carer_relationship = $this->common->encrypt_decrypt($requestData['parent_carer_relationship'], 'encrypt');
        }
        if ($orderObj->save()) {
            $orderId = $orderObj->id;
            $orderItems = $this->saveOrderItems($requestData, $orderId);
            return $orderId;
        }
        return false;
    }

    /**
     * Save Order Items.
     *
     */
    public function saveOrderItems($requestData, $orderId)
    {
        if (isset($requestData['order_items']) && $requestData['order_items']) {
            $orderItemDelete = OrderItems::where('orders_id', $orderId)->delete();
            foreach ($requestData['order_items'] as $ord_value) {
                $orderItems = new OrderItems();
                $orderItems->orders_id = $orderId;
                $orderItems->item_name = $ord_value['item_name'];
                $orderItems->item_quantity = $ord_value['item_quantity'];
                $orderItems->item_price = $ord_value['item_price'];
                $orderItems->product_category = $ord_value['product_category'];
                $orderItems->product_category_item = $ord_value['product_category_item'];
                $orderItems->save();
            }
            return true;
        }
        return false;
    }

    /**
     * Get NDIS Plan.
     *
     */
    public function getNdisPlan($requestData)
    {
        $requestData['participant'] = $requestData['ndis_participant_number'];
        $requestData['participant_surname'] = $requestData['ndis_participant_last_name'];
        $requestData['date_of_birth'] = $requestData['ndis_participant_date_of_birth'];
        $planData = $this->ndisExternal->getParticipantPlan($requestData);
        if (isset($planData['code']) && $planData['code'] == 200) {
            $planResults =  json_decode($planData['result'], true);
            if (isset($planResults['result'][0]['participant_plan_id'])) {
                return $planResults['result'][0]['participant_plan_id'];
            }
        }
        return false;
    }

    /**
     * Service Book.
     *
     */
    public function getRealCategoryCode($itemNumber)
    {
        $itemCode = substr($itemNumber, 0, 2);
        if ($itemCode == '03') {
            return 'CONSUMABLES';
        } else if ($itemCode == '05') {
            return 'ASSISTIVE_TECHNOLOGY';
        } else if ($itemCode == '06') {
            return 'HOME_MODIFICATIONS';
        } else {
            return 'CONSUMABLES';
        }
    }
    public function serviceBook($requestData, $participatePlanId, $orderId)
    {
        $participant            = $requestData['ndis_participant_number'];
        $participant_surname    = $requestData['ndis_participant_last_name'];
        $date_of_birth          = date('Y-m-d', strtotime($requestData['ndis_participant_date_of_birth']));
        $participant_plan_id    = $participatePlanId;
        $booking_type           = config('ndis.booking_type');
        if (isset($requestData['booking_type']) && $requestData['booking_type']) {
            $booking_type = $requestData['booking_type'];
        }
        $start_date             = date('Y-m-d');
        $end_date               = date('Y-m-d');
        if (isset($requestData['start_date']) && $requestData['start_date']) {
            $start_date = date('Y-m-d', strtotime($requestData['start_date']));
        }
        if (isset($requestData['end_date']) && $requestData['end_date']) {
            $end_date = date('Y-m-d', strtotime($requestData['end_date']));
        }
        $items = [];
        $itemCount = count($requestData['order_items']);

        $trialCount = $shippingCharge = $gstTotal = 0;
        if (isset($requestData['shipping_total']) && $requestData['shipping_total']) {
            $shippingCharge = $requestData['shipping_total'];
        }
        if (isset($requestData['gst_total']) && $requestData['gst_total']) {
            $gstTotal = $requestData['gst_total'];
        }
        /*$totalCharge = $shippingCharge + $gstTotal;
        if ($totalCharge > 0 && $itemCount > 0) {
            $totalCharge = $totalCharge / $itemCount;
        }*/

        $orderItems = OrderItems::select('id as order_item_id', 'item_quantity', 'item_price', 'product_category', 'product_category_item')->where('orders_id', $orderId)->Orderby('id')->get()->toArray();

        foreach ($orderItems as $key => $oValue) {
            $totalItem[] = count(explode(",", $oValue['product_category_item']));
        }
        $maxTrial = min($totalItem);

        for ($i = 0; $i < $maxTrial; $i++) {
            $items = $itemKey = [];
            $totalQty = 0;
            foreach ($orderItems as $key => $oValue) {
                $pcArray = explode(",", $oValue['product_category_item']);
                if (array_key_exists($pcArray[$i], $itemKey)) {
                    $calPrice = (($itemKey[$pcArray[$i]]['item_price'] * $itemKey[$pcArray[$i]]['item_quantity']) + ($oValue['item_price'] *  $oValue['item_quantity']));
                    $calPriceNew = $calPrice / ($itemKey[$pcArray[$i]]['item_quantity'] + $oValue['item_quantity']);
                    $itemKey[$pcArray[$i]] =
                        [
                            'order_item_id' => $oValue['order_item_id'],
                            'product_category' => $oValue['product_category'],
                            'item_quantity' => ($itemKey[$pcArray[$i]]['item_quantity'] + $oValue['item_quantity']),
                            // 'item_price' => ($itemKey[$pcArray[$i]]['item_price'] + $oValue['item_price'])];
                            // 'item_price' => ($itemKey[$pcArray[$i]]['item_price'] + ($oValue['item_price'] *  $oValue['item_quantity']) )]; 
                            'item_price' => ($calPriceNew)
                        ];
                } else {
                    $itemKey[$pcArray[$i]] =
                        [
                            'order_item_id' => $oValue['order_item_id'],
                            'product_category' => $oValue['product_category'],
                            'item_quantity' => $oValue['item_quantity'],
                            'item_price' => $oValue['item_price']
                        ];
                }
                $totalQty = $totalQty + $oValue['item_quantity'];
            }
            $itemCount = $totalQty; //count($itemKey);
            $totalCharge = $shippingCharge + $gstTotal;
            if ($totalCharge > 0 && $itemCount > 0) {
                $totalCharge = $totalCharge / $itemCount;
            }
            $j = 0;

            foreach ($itemKey as $key => $pcItemValue) {
                //$totalUnitPrice = (($pcItemValue['item_price'] * $pcItemValue['item_quantity']) + $totalCharge);
                $totalUnitPrice = (($pcItemValue['item_price'] * $pcItemValue['item_quantity']) + ($totalCharge * $pcItemValue['item_quantity']));
                $perUnitPrice = round(($totalUnitPrice / $pcItemValue['item_quantity']), 2);
                $items[$j]['product_category']      = $this->getRealCategoryCode($key); //$pcItemValue['product_category'];
                $items[$j]['product_category_item'] = $key;
                $items[$j]['quantity']              = $pcItemValue['item_quantity'];
                $items[$j]['per_unit_price']        = $perUnitPrice;

                $productItems[$j]['product_category'] = $pcItemValue['product_category'];
                $productItems[$j]['product_category_item'] = $this->getRealCategoryCode($key); //$key;
                $productItems[$j]['order_item_id'] = $pcItemValue['order_item_id'];
                $productItems[$j]['quantity']      = $pcItemValue['item_quantity'];
                $productItems[$j]['per_unit_price'] = round($totalUnitPrice, 2);
                $j++;
            }

            ini_set('serialize_precision', -1);
            $items = json_encode($items);

            $form_param = '{
                "participant":' . $participant . ',
                "participant_surname":"' . $participant_surname . '",
                "date_of_birth":"' . $date_of_birth . '",
                "booking_type":"' . $booking_type . '",
                "start_date":"' . $start_date . '",
                "end_date":"' . $end_date . '",
                "participant_plan_id":' . $participant_plan_id . ',
                    "items":' . $items . '}';
            $formData = $form_param;
            $serviceBookingData = $this->ndisExternal->createServiceBooking($formData);

            if (isset($serviceBookingData['result']) && $serviceBookingData['result']) {
                $s_data = json_decode($serviceBookingData['result'], true);
                if (isset($s_data['success']) && $s_data['success'] == true) {
                    $serviceBookingId = '';
                    if (isset($s_data['result']['service_booking_id'])) {
                        $serviceBookingId = $s_data['result']['service_booking_id'];
                    }
                    return ['service_booking_id' => $serviceBookingId, 'api_response' => $serviceBookingData['result'], 'product_items' => $productItems];
                } else {
                    $orderData = Orders::where('id', $orderId)->first();
                    if ($orderData) {
                        if (is_array($serviceBookingData['result'])) {
                            $serviceBookingData['result'] = json_encode($serviceBookingData['result']);
                        }
                        $orderData->response = $serviceBookingData['result'];
                        $orderData->save();
                    }
                }
            } else {
                $orderData = Orders::where('id', $orderId)->first();
                if ($orderData) {
                    if (is_array($serviceBookingData)) {
                        $serviceBookingData = json_encode($serviceBookingData);
                    }
                    $orderData->response = $serviceBookingData;
                    $orderData->save();
                }
            }
        }



        /* foreach ($orderItems as $key => $oiValue) {
            $perUnitPrice = round(($oiValue['item_price'] + $totalCharge),2);
            $items[$key]['product_category']      = $oiValue['product_category'];
            $items[$key]['product_category_item'] = $oiValue['product_category_item'];
            $items[$key]['quantity']              = $oiValue['item_quantity'];
            $items[$key]['per_unit_price']        = $perUnitPrice;

            $productItems[$key]['product_category'] = $oiValue['product_category'];
            $productItems[$key]['product_category_item'] = $oiValue['product_category_item'];
            $productItems[$key]['order_item_id'] = $oiValue['order_item_id'];
            $productItems[$key]['quantity']      = $oiValue['item_quantity'];
            $productItems[$key]['per_unit_price']= $perUnitPrice;
        }

        ini_set('serialize_precision', -1);
        $items = json_encode($items);
                
        $form_param = '{
            "participant":'.$participant.',
            "participant_surname":"'.$participant_surname.'",
            "date_of_birth":"'.$date_of_birth.'",
            "booking_type":"'.$booking_type.'",
            "start_date":"'.$start_date.'",
            "end_date":"'.$end_date.'",
            "participant_plan_id":'.$participant_plan_id.',
                "items":'.$items.'}';
        $formData = $form_param;
        $serviceBookingData = $this->ndisExternal->createServiceBooking($formData);

        if (isset($serviceBookingData['result']) && $serviceBookingData['result']) {
            $s_data = json_decode($serviceBookingData['result'],true);
            if (isset($s_data['success']) && $s_data['success'] == true) {
                $serviceBookingId = '';
                if (isset($s_data['result']['service_booking_id'])) {
                    $serviceBookingId = $s_data['result']['service_booking_id'];
                }
                return ['service_booking_id' => $serviceBookingId, 'api_response' => $serviceBookingData['result'] , 'product_items' => $productItems];
            } else {
                $orderData = Orders::where('id',$orderId)->first();
                if ($orderData) {
                    if (is_array($serviceBookingData['result'])) {
                        $serviceBookingData['result'] = json_encode($serviceBookingData['result']);
                    }
                    $orderData->response = $serviceBookingData['result'];
                    $orderData->save();
                }
            }
        } else {
            $orderData = Orders::where('id',$orderId)->first();
            if ($orderData) {
                if (is_array($serviceBookingData)) {
                    $serviceBookingData = json_encode($serviceBookingData);
                }
                $orderData->response = $serviceBookingData;
                $orderData->save();
            }
        }

        $productItems = ProductCategoryItems::where('category_name',$requestData['product_category'])->pluck('item_number')->toArray();

        $combinationArray = $possibility = $possibilityArray = [];
        for ($i=0; $i < $itemCount; $i++) { 
            $combinationArray[] = $productItems;
        }

        $possibility = $this->common->combinations($combinationArray);
       
        foreach ($possibility as $value) {
            $possibilityArray[] = explode(',', $value);
        }

        foreach ($possibilityArray as $itemValue) {
            $categoryItems = $items = $productItems = [];
            $continue = 0;
            foreach ($orderItems as $key => $ordValue) {
                if (in_array($itemValue[$key], $categoryItems)) {   
                    $continue = 1;
                    break;
                } else {
                    $perUnitPrice = round(($ordValue['item_price'] + $totalCharge),2);
                    $items[$key]['product_category']      = $requestData['product_category'];
                    $items[$key]['product_category_item'] = $itemValue[$key];
                    $items[$key]['quantity']              = $ordValue['item_quantity'];
                    $items[$key]['per_unit_price']        = $perUnitPrice;
                    $categoryItems[] = $itemValue[$key];

                    $productItems[$key]['product_category'] = $requestData['product_category'];
                    $productItems[$key]['product_category_item'] = $itemValue[$key];
                    $productItems[$key]['order_item_id'] = $ordValue['order_item_id'];
                    $productItems[$key]['quantity']      = $ordValue['item_quantity'];
                    $productItems[$key]['per_unit_price']= $perUnitPrice;
                }
            }
            if ($continue) {
                continue;
            } else {
                $maximumTrial = config('ndis.maximum_trial');
                if ($trialCount >=  $maximumTrial) {
                    break;    
                }
                ini_set('serialize_precision', -1);
                $items = json_encode($items);
                
                $form_param = '{
                    "participant":'.$participant.',
                    "participant_surname":"'.$participant_surname.'",
                    "date_of_birth":"'.$date_of_birth.'",
                    "booking_type":"'.$booking_type.'",
                    "start_date":"'.$start_date.'",
                    "end_date":"'.$end_date.'",
                    "participant_plan_id":'.$participant_plan_id.',
                        "items":'.$items.'}';

                $formData = $form_param;
                $serviceBookingData = $this->ndisExternal->createServiceBooking($formData);
                $trialCount = $trialCount + 1;
                if (isset($serviceBookingData['result']) && $serviceBookingData['result']) {
                    $s_data = json_decode($serviceBookingData['result'],true);
                    if (isset($s_data['success']) && $s_data['success'] == true) {
                        $serviceBookingId = '';
                        if (isset($s_data['result']['service_booking_id'])) {
                            $serviceBookingId = $s_data['result']['service_booking_id'];
                        }
                        return ['service_booking_id' => $serviceBookingId, 'api_response' => $serviceBookingData['result'] , 'product_items' => $productItems];
                    }
                }
            }
        }*/
        return false;
    }

    /**
     * Internal Service Book.
     *
     */
    public function internalServiceBook($serviceBooking, $orderId)
    {
        $serviceBooking['service_booking_id'] = $this->common->encrypt_decrypt($serviceBooking['service_booking_id'], 'encrypt');
        $serBook = NdisServiceBooking::where('orders_id', $orderId)->where('service_booking_id',)->first();
        if ($serBook) {
            $serBook->orders_id = $orderId;
            $serBook->service_booking_id = $serviceBooking['service_booking_id'];
            $serBook->status = 1;
            $serBook->api_response = $this->common->encrypt_decrypt($serviceBooking['api_response'], 'encrypt');
            if ($serBook->save()) {
                return $serBook->id;
            }
        } else {
            $serBook = new NdisServiceBooking();
            $serBook->orders_id = $orderId;
            $serBook->service_booking_id = $serviceBooking['service_booking_id'];
            $serBook->status = 1;
            $serBook->api_response = $this->common->encrypt_decrypt($serviceBooking['api_response'], 'encrypt');
            if ($serBook->save()) {
                return $serBook->id;
            }
        }
        return false;
    }

    /**
     * Internal Service Book.
     *
     */
    public function createPayment($requestData, $orderId, $service_booking_id)
    {
        $claim_type = $claim_reason = $unit_of_measure =  '';
        $tax_code = config('ndis.tax_code');

        $client_ref_num         = $requestData['order_number'];
        $product_category       = $requestData['product_category'];
        $product_category_item  = $requestData['product_category_item'];
        $quantity               = $requestData['quantity'];
        $claimed_amount         = $requestData['claimed_amount'];
        $participant            = $requestData['ndis_participant_number'];
        if (isset($requestData['tax_code']) && $requestData['tax_code']) {
            $tax_code = $requestData['tax_code'];
        }
        if (isset($requestData['claim_type']) && $requestData['claim_type']) {
            $claim_type = $requestData['claim_type'];
        }
        if (isset($requestData['claim_reason']) && $requestData['claim_reason']) {
            $claim_reason = $requestData['claim_reason'];
        }
        $start_date             = date('Y-m-d');
        $end_date               = date('Y-m-d');
        if (isset($requestData['start_date']) && $requestData['start_date']) {
            $start_date = date('Y-m-d', strtotime($requestData['start_date']));
        }
        if (isset($requestData['end_date']) && $requestData['end_date']) {
            $end_date = date('Y-m-d', strtotime($requestData['end_date']));
        }

        if (isset($requestData['unit_of_measure']) && $requestData['unit_of_measure']) {
            $unit_of_measure = $requestData['unit_of_measure'];
        }
        $form_param = '{
                "ref_doc_no":"' . $client_ref_num . '",
                "service_agreement":' . $service_booking_id . ',
                "product_category":"' . $product_category . '",
                "product_category_item":"' . $product_category_item . '",
                "participant":' . $participant . ',
                "claimed_amount":' . $claimed_amount . ',
                "quantity":' . $quantity . ',
                "tax_code":"' . $tax_code . '",
                "claim_type":"' . $claim_type . '",
                "claim_reason":"' . $claim_reason . '",
                "start_date":"' . $start_date . '",
                "end_date":"' . $end_date . '",
                "unit_of_measure":"' . $unit_of_measure . '"
            }';

        $createPaymentData = $this->ndisExternal->createPaymentRequest($form_param);
        if (isset($createPaymentData['result']) && $createPaymentData['result']) {
            $paymentData = json_decode($createPaymentData['result'], true);
            $claimNumber = $claimStatus = '';
            if (isset($paymentData['result']['claim_number'])) {
                $claimNumber = $paymentData['result']['claim_number'];
                $claimStatus = $paymentData['result']['claim_status'];
            } else {
                $orderItemsData = OrderItems::where('id', $requestData['order_item_id'])->first();
                if ($orderItemsData) {
                    if (is_array($createPaymentData['result'])) {
                        $createPaymentData['result'] = json_encode($createPaymentData['result']);
                    }
                    $orderItemsData->response = $createPaymentData['result'];
                    $orderItemsData->save();
                }
            }
            return ['claim_number' => $claimNumber, 'claim_status' => $claimStatus, 'api_response' => $createPaymentData['result']];
        } else {
            $orderItemsData = OrderItems::where('id', $requestData['order_item_id'])->first();
            if ($orderItemsData) {
                if (is_array($createPaymentData)) {
                    $createPaymentData = json_encode($createPaymentData);
                }
                $orderItemsData->response = $createPaymentData;
                $orderItemsData->save();
            }
        }
        return false;
    }

    /**
     * internal create payment
     *
     */
    public function internalCreatePayment($paymentCreate, $orderId, $ndisServiceBookId, $orderItemId)
    {
        $paymentRequest = new NdisPaymentRequest();
        $paymentRequest->ndis_service_booking_id = $ndisServiceBookId;
        $paymentRequest->orders_id = $orderId;
        $paymentRequest->order_item_id = $orderItemId;
        if (isset($paymentCreate['claim_number']) && $paymentCreate['claim_number']) {
            $paymentRequest->claim_number = $paymentCreate['claim_number'];
        }
        if (isset($paymentCreate['api_response']) && $paymentCreate['api_response']) {
            $paymentRequest->api_response = $this->common->encrypt_decrypt($paymentCreate['api_response'], 'encrypt');
        }
        $paymentRequest->status = 4;
        if ($paymentRequest->save()) {
            return true;
        }
        return false;
    }

    /**
     * encrypt decrypt data.
     *
     */
    public function encryptDecryptData($requestData)
    {
        return $this->common->encrypt_decrypt($requestData['string'], $requestData['action']);
    }
}
