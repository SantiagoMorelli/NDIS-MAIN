<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\NdisInternalApiRepository;
use Validator;
use App\Traits\ApiResponser;

class NdisInternalApiController extends Controller
{
    use ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(NdisInternalApiRepository $ndisInternal) {
        $this->ndisInternal = $ndisInternal;
    }
    
    /**
     * Submit Order.
     *
     */
    public function submitOrder(Request $request) {
        $requestData = $request->json()->all();
        $validation = $this->validateOrder($requestData, 'submit');
        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (isset($requestData['order_items']) && $requestData['order_items']) {
            foreach ($requestData['order_items'] as $value) {
                $value['ndis_plan_management_option'] = $requestData['ndis_plan_management_option'];
                $validationItem = $this->validateOrder($value, 'order_item_details');
                if ($validationItem->fails()) {
                    return $this->throwValidation($validationItem->messages()->first(), Response::HTTP_UNPROCESSABLE_ENTITY);
                }
            }
        }
        
        $data = $this->ndisInternal->submitOrder($requestData);
        if ($data && $data == "OrderExists") {
            return $this->errorResponse('Order Number already exists.', Response::HTTP_CONFLICT);
        } else if ($data) {
            return $this->orderResponse($data['order_status'], 0);
        }
        return $this->orderResponse('Error', 1);
    }

    /**
     * Update order status.
     *
     */
    public function updateOrderStatus(Request $request) {
        $requestData = $request->json()->all();
        $validation = $this->validateOrder($requestData, 'update_order_status');
        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $data = $this->ndisInternal->updateOrderStatus($requestData);
        if ($data) {
            return $this->successResponse('Order data get successfully.', Response::HTTP_OK, $data);
        }
        return $this->errorResponse('Order not found.', Response::HTTP_NOT_FOUND);
    }

    /**
     * Validation
     *
     * @param array $requestData
     * @param string $social - optional
     * @param array $data - optional
     * @return Illuminate\Http\JsonResponse
     */
    public function validateOrder($requestData, $social = '', $data = '') {
        $emailRequired = 'email';
        $planManagerName = $invoiceRequired = '';
        if (isset($requestData['ndis_plan_management_option']) && $requestData['ndis_plan_management_option'] == config('ndis.plan_management_option.plan_managed')) {
            $planManagerName            = 'required';
            $emailRequired              = 'required|email';
            $invoiceRequired            = 'required';
        }
        switch ($social) {
            case 'submit':
                return $validation = Validator::make($requestData, [
                        'order_number'                      => 'required',
                        'order_date'                        => 'required|date_format:Y-m-d',
                        'order_items'                       => 'required',
                        'ndis_participant_first_name'       => 'required',
                        'ndis_participant_last_name'        => 'required',
                        'ndis_participant_number'           => 'required',
                        'ndis_participant_date_of_birth'    => 'required|date_format:Y-m-d',
                        'order_total'                       => 'required|regex:/^\d+(\.\d{1,2})?$/',
                        'product_category'                  => 'required|max:255',
                        'ndis_plan_management_option'       => 'required',
                        'plan_manager_name'                 => $planManagerName,
                        'invoice_email_address'             => $emailRequired,
                        'invoice_no'                        => $invoiceRequired,
                        'shipping_total'                    => 'regex:/^\d+(\.\d{1,2})?$/',
                        'product_total'                     => 'regex:/^\d+(\.\d{1,2})?$/',
                        'total_ex_tax'                      => 'regex:/^\d+(\.\d{1,2})?$/',
                        'gst_total'                         => 'regex:/^\d+(\.\d{1,2})?$/',
                    ]);
                break;
            case 'order_item_details':
                return $validation = Validator::make($requestData, [
                        'item_name'        => 'required',
                        'item_quantity'    => 'required|integer',
                        'item_price'       => 'required|regex:/^\d+(\.\d{1,2})?$/',
                        'product_category' => 'required|max:255',
                        'product_category_item' => 'required|max:255',
                        'gst'              => 'regex:/^\d+(\.\d{1,2})?$/',
                    ]);
                break;
            case 'update_order_status':
                return $validation = Validator::make($requestData, [
                        'order_number' => 'required',
                    ]);
                break;
            default:
                
                break;
        }
    }

    /**
     * encrypt decrypt data.
     *
     */
    public function encryptDecryptData(Request $request) {
        $data = $this->ndisInternal->encryptDecryptData($request->json()->all());
        return response($data)->header('Content-Type', 'application/json');
    }
}