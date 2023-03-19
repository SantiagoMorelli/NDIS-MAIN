<?php

namespace App\Http\Controllers\ManagementPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\ManagementPortal\OrderRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\Orders;
use App\Models\OrderItems;
use DataTables;
use App\Models\BcmOrder;
use App\Repositories\CommonRepository;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    

    public function __construct(OrderRepository $order, CommonRepository $common) {
        $this->order = $order;
        $this->common = $common;
    }

    /**
     * Get Ndia Managed Orders.
     *
     */
    public function getAllOrders() {
        if(request()->ajax()) {
            $data = $this->order->getAllOrders();
            return datatables()->of($data)
            ->editColumn('order_status', function ($row){
                if ($row['order_status'] == 1) {
                    return 'Submited';     
                } else if ($row['order_status'] == 2) {
                    return 'Resubmited';     
                } else if ($row['order_status'] == 3) {
                    return 'Paid';     
                } else {
                    return 'Error';
                }
            })
            ->editColumn('order_date', function ($row){
                if ($row['order_date']) {
                    return date('Y-m-d',strtotime($row['order_date']));
                }
                return '';
            })
            ->editColumn('service_booking_id', function ($row){
                if ($row['service_booking_id']) {
                    return CommonRepository::encrypt_decrypt($row['service_booking_id'],'decrypt');
                }
                return '';
            })
            ->editColumn('response', function ($row){
                $response = '';
                if ($row['order_status'] == 0) {
                    $response = $row['response'];   
                }
                return $response;
            })
            ->addColumn('customer_name', function($row){
                return CommonRepository::encrypt_decrypt($row['customer_first_name'],'decrypt').' '.CommonRepository::encrypt_decrypt($row['customer_last_name'],'decrypt');
            })
            ->addColumn('type', function($row){
                return '';
            })
            ->addColumn('action', function($row) {
                $paidbutton = $resubmitButton = '';
                if ($row['order_status'] == 0) {
                    $resubmitButton = '<button type="button" class="btn btn-warning shadow-sm btn--sm mr-2"
                            data-toggle="tooltip" data-placement="left"
                            onclick="resubmitOrder('.$row['id'].')">Resubmit
                        </button>';
                }
                if ($row['order_status'] != 3) {

                    
                    $paidbutton = '<button type="button" class="btn btn-success shadow-sm btn--sm mr-2"
                            data-toggle="tooltip" data-placement="left"
                            onclick="changeOrderStatus('.$row['id'].')">Edit Order Status
                        </button>';
                }
                return '<a href="'. url('/admin/order/edit/'.$row['id']).'"><button type="button"
                            class="btn btn-info shadow-sm btn--sm mr-2 acceptid"
                            data-toggle="tooltip" data-placement="left" >Mark as submitted
                        </button></a>'
                        .$resubmitButton.
                        '
                        <a href="'. url('/admin/order/view/'.$row['id']).'"><button type="button" class="btn btn-primary shadow-sm btn--sm mr-2"
                            data-toggle="tooltip" data-placement="left"
                            >View
                        </button></a>'.$paidbutton;
            })
            ->make(true);
        }
        return View('admin.order.list');
    }

    /**
     * Get Plan Managed Orders.
     *
     */
    public function getPlanManagedOrders() {
        if(request()->ajax()) {
            $data = $this->order->getPlanManagedOrders();
            return datatables()->of($data)
            ->editColumn('order_status', function ($row){
                if ($row['order_status'] == 1) {
                    return 'Submited';     
                } else if ($row['order_status'] == 2) {
                    return 'Resubmited';     
                } else if ($row['order_status'] == 3) {
                    return 'Paid';     
                } else {
                    return 'Error';
                }
            })
            ->editColumn('order_date', function ($row){
                if ($row['order_date']) {
                    return date('Y-m-d',strtotime($row['order_date']));
                }
                return '';
            })
            ->editColumn('response', function ($row){
                $response = '';
                if ($row['order_status'] == 0) {
                    $response = $row['response'];   
                }
                return $response;
            })
            ->addColumn('customer_name', function($row){
                return CommonRepository::encrypt_decrypt($row['customer_first_name'],'decrypt').' '.CommonRepository::encrypt_decrypt($row['customer_last_name'],'decrypt');
            })
            ->addColumn('type', function($row){
                return '';
            })
            ->addColumn('action', function($row) {
                $paidbutton = $resubmitButton = '';
                if ($row['order_status'] == 0) {
                    $resubmitButton = '<button type="button" class="btn btn-warning shadow-sm btn--sm mr-2"
                            data-toggle="tooltip" data-placement="left"
                            onclick="resubmitOrder('.$row['id'].')">Resubmit
                        </button>';
                }
                if ($row['order_status'] != 3) {

                    $paidbutton = '<button type="button" class="btn btn-success shadow-sm btn--sm mr-2"
                            data-toggle="tooltip" data-placement="left"
                            onclick="changeOrderStatus('.$row['id'].')">Mark Order as Paid
                        </button>';
                }
                return '
                        <a href="'. url('/admin/order/view/'.$row['id']).'"><button type="button" class="btn btn-primary shadow-sm btn--sm mr-2"
                            data-toggle="tooltip" data-placement="left"
                            >View
                        </button></a>'.$paidbutton;
            })
            ->make(true);
        }
        return View('admin.order.list_plan_managed');
    }

    /**
     * Get Order Items.
     *
     */
    public function getOrderItems($id) {
        if(request()->ajax()) {
            $data = $this->order->getOrderItems($id);
            return datatables()->of($data)
            ->editColumn('status', function ($row){
                return config('ndis.claimStatus.'.$row['status']);
            })
            ->addColumn('action', function($row) {
                return '<a href="'. url('/admin/order_items/edit/'.$row['item_id']).'"><button type="button"
                            class="btn btn-info shadow-sm btn--sm mr-2 acceptid"
                            data-toggle="tooltip" data-placement="left" >Edit
                        </button></a>';
            })
            ->make(true);
        }
        return View('admin.order.item_list')->with(['orderId' => $id]);
    }

    /**
     * Edit Order.
     *
     */
    public function editOrder(Request $request, $id = '') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->order->editOrder($request->all());
            if ($data) {
                // audit change log
                $requestData['page_id'] = 'Order Details Page';
                $requestData['action'] = 'order updated';
                $requestData['orders_id'] = $request->id;
                $log = $this->order->auditChangeLog($requestData);

                return redirect(route('getOrders'))->with('success','Order updated successfully.');
            }
            return redirect(route('getOrders'))->with('error','Something went wrong!');
        }

        $orderData = Orders::find($id);
        if (!$orderData) {
            return redirect(route('getOrders'));
        }
        return View('admin.order.edit')->with('order',$orderData);
    }

    /**
     * Edit Order Item.
     *
     */
    public function editOrderItem(Request $request, $id = '') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->order->editOrderItem($request->all());
            if ($data) {
                return redirect(url('/admin/order/view').'/'.$request->orders_id)->with('success','Order Item updated successfully.');
            }
            return redirect(route('getOrders'))->with('error','Something went wrong!');
        }

        $orderItemData = OrderItems::find($id);
        if (!$orderItemData) {
            return redirect(route('getOrders'));
        }
        return View('admin.order.edit_items')->with('orderItem',$orderItemData);
    }

    /**
     * Edit Order.
     *
     */
    public function viewOrder($id) {
        $orderData = Orders::find($id);
        if (!$orderData) {
            return redirect(route('getOrders'));
        }

        $planOptions = $this->common->encrypt_decrypt($orderData['ndis_plan_management_option'],'decrypt');
        $planManaged = false;
        if ($planOptions == config('ndis.plan_management_option.plan_managed')) {
            $planManaged = true;
        }
        // audit change log
        $requestData['page_id'] = 'Order Details Page';
        $requestData['action'] = 'order viewed';
        $requestData['orders_id'] = $id;
        $log = $this->order->auditChangeLog($requestData);

        return View('admin.order.view')->with('order',$orderData)->with(['orderId' => $id,'planManaged' => $planManaged]);
    }

    /**
     * Update Order Status.
     *
     */
    public function updateOrderStatus(Request $request) {
        return $this->order->updateOrderStatus($request->all());
    }


    /**
     * Resubmit Order.
     *
     */
    public function resubmitOrder(Request $request) {
        return $this->order->resubmitOrder($request->all());
    }

    /**
     * Update Order Item Status Cron.
     *
     */
    public function updateOrderItemStatusCron() {
        $data = $this->order->updateOrderItemStatusCron();
        if ($data) {
            return 'Update Order Item Status Cron run successfully.';
        }
        return 'Update Order Item Status Cron failed.';
    }

}