<?php

namespace App\Repositories;

use App\Models\BcmOrders;
use App\Models\BcmOrderItems;
use App\Repositories\CommonRepository;
use PDF;

class BcmOrderRepository
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CommonRepository $common, NdisAuthenticationRepository $ndisAuthentication)
    {
        $this->common = $common;
    }

    /**
     * Submit Order.
     *
     */
    public function submitOrder($requestData)
    {
        $orderObj = BcmOrders::where('order_number', $requestData['order_number'])->first();
        if ($orderObj) {
            return 'OrderExists';
        }
        $orderId = $this->saveData($requestData);
    }


    /**
     * Save Data.
     *
     */
    public function saveData($requestData)
    {
        $orderObj = new BcmOrders();
        return $this->saveOrderData($orderObj, $requestData);
    }

    /**
     * Save Order Data.
     *
     */
    public function saveOrderData($orderObj, $requestData)
    {
        $orderObj->order_number = $requestData['order_number'];
        $orderObj->order_date = $requestData['order_date'];
        $orderObj->order_status = $requestData['order_status'];
        $orderObj->order_discount = $requestData['order_discount'];
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
            $orderObj->customer_first_name = $requestData['customer_first_name'];
        }
        if (isset($requestData['customer_last_name']) && $requestData['customer_last_name']) {
            $orderObj->customer_last_name = $requestData['customer_last_name'];
        }
        if (isset($requestData['customer_date_of_birth']) && $requestData['customer_date_of_birth']) {
            $orderObj->customer_date_of_birth = $requestData['customer_date_of_birth'];
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
        // //needs to be checked after API is developed
        // if (isset($requestData['bcm_payment_option']) && $requestData['bcm_payment_option']) {
        //     $orderObj->bcm_payment_option = $this->common->encrypt_decrypt($requestData['bcm_payment_option'], 'encrypt');
        // }
        // if (isset($requestData['product_category']) && $requestData['product_category']) {
        //     $orderObj->product_category = $requestData['product_category'];
        // }
        if ($orderObj->save()) {
            $orderId = $orderObj->order_number;
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
        print_r($requestData);
        if (isset($requestData['order_items']) && $requestData['order_items']) {
            $orderItemDelete = BcmOrderItems::where('orders_id', $orderId)->delete();
            foreach ($requestData['order_items'] as $ord_value) {
                $orderItems = new BcmOrderItems();
                $orderItems->orders_id = $orderId;
                $orderItems->item_name = $ord_value['item_name'];
                $orderItems->item_sku = $ord_value['product_sku'];
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
}