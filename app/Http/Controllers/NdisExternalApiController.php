<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\NdisExternalApiRepository;
use App\Repositories\CommonRepository;

class NdisExternalApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(NdisExternalApiRepository $ndis, CommonRepository $common) {
        $this->ndis = $ndis;
        $this->common = $common;
    }
    
    /**
     * Get Participant Plan Details.
     *
     */
    public function getParticipantPlan(Request $request) {
        $data = $this->ndis->getParticipantPlan($request->all());
        if (isset($data['code']) && $data['code'] == 200) {
            return response($data['result'])->header('Content-Type', 'application/json');
        } else if(isset($data['errors']) && $data['errors']) {
            return response($data['errors'])->header('Content-Type', 'application/json');
        } else {
            return response($data['result'])->header('Content-Type', 'application/json');
        }
    }

    /**
     * Get Reference Data.
     *
     */
    public function getReferenceData(Request $request) {
        $data = $this->ndis->getReferenceData($request->all());
        if (isset($data['code']) && $data['code'] == 200) {
            return response($data['result'])->header('Content-Type', 'application/json');
        } else if(isset($data['errors']) && $data['errors']) {
            return response($data['errors'])->header('Content-Type', 'application/json');
        } else {
            return response($data['result'])->header('Content-Type', 'application/json');
        }
    }

    /**
     * Create a new service booking.
     *
     */
    public function createServiceBooking(Request $request) {
        $requestData = $request->json()->all();
        
        $participant           = $requestData['participant'];
        $participant_surname   = $requestData['participant_surname'];
        $date_of_birth         = $requestData['date_of_birth'];
        $participant_plan_id   = $requestData['participant_plan_id'];
        $booking_type          = config('ndis.booking_type');
        if (isset($requestData['booking_type']) && $requestData['booking_type']) {
            $booking_type = $requestData['booking_type'];
        }
        $start_date             = date('Y-m-d');
        $end_date               = date('Y-m-d');
        if (isset($requestData['start_date']) && $requestData['start_date']) {
            $start_date = date('Y-m-d',strtotime($requestData['start_date']));
        }
        if (isset($requestData['end_date']) && $requestData['end_date']) {
            $end_date = date('Y-m-d',strtotime($requestData['end_date']));
        }

        $items = [];
        if (isset($requestData['product_items']) && $requestData['product_items']) {
            foreach ($requestData['product_items'] as $key => $prod_value) {
                $items[$key] = $prod_value;
            }
        }
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

        $data = $this->ndis->createServiceBooking($form_param);
        if (isset($data['code']) && ($data['code'] == 200 || $data['code'] == 201)) {
            return response($data['result'])->header('Content-Type', 'application/json');
        } else if(isset($data['errors']) && $data['errors']) {
            return response($data['errors'])->header('Content-Type', 'application/json');
        } else {
            return response($data['result'])->header('Content-Type', 'application/json');
        }
    }

    /**
     * Update service booking.
     *
     */
    public function updateServiceBooking(Request $request) {
        $data = $this->ndis->updateServiceBooking($request->all());
        if (isset($data['code']) && $data['code'] == 200) {
            return response($data['result'])->header('Content-Type', 'application/json');
        } else if(isset($data['errors']) && $data['errors']) {
            return response($data['errors'])->header('Content-Type', 'application/json');
        } else {
            return response($data['result'])->header('Content-Type', 'application/json');
        }
    }

    /**
     * Get service booking.
     *
     */
    public function getServiceBooking(Request $request) {
        $data = $this->ndis->getServiceBooking($request->all());
        if (isset($data['code']) && $data['code'] == 200) {
            return response($data['result'])->header('Content-Type', 'application/json');
        } else if(isset($data['errors']) && $data['errors']) {
            return response($data['errors'])->header('Content-Type', 'application/json');
        } else {
            return response($data['result'])->header('Content-Type', 'application/json');
        }
    }
    
    /**
     * Delete service booking.
     *
     */
    public function deleteServiceBooking($service_booking_id) {
        $data = $this->ndis->deleteServiceBooking($service_booking_id);
        if (isset($data['code']) && $data['code'] == 200) {
            return response($data['result'])->header('Content-Type', 'application/json');
        } else if(isset($data['errors']) && $data['errors']) {
            return response($data['errors'])->header('Content-Type', 'application/json');
        } else {
            return response($data['result'])->header('Content-Type', 'application/json');
        }
    }

    /**
     * Create Payment Request.
     *
     */
    public function createPaymentRequest(Request $request) {
        $requestData = $request->json()->all();

        $product_category_item  = $claim_type = $claim_reason = $unit_of_measure =  '';
        $client_ref_num = 'ABCD1234';
        $tax_code = config('ndis.tax_code');
        $service_booking_id     = $requestData['service_booking_id'];
        $product_category       = $requestData['product_category'];
        if (isset($requestData['product_category_item'])) {
            $product_category_item = $requestData['product_category_item'];
        }
        $participant            = $requestData['participant'];
        $claimed_amount         = $requestData['claimed_amount'];
        $quantity               = $requestData['quantity'];
        $start_date             = date('Y-m-d');
        $end_date               = date('Y-m-d');
        if (isset($requestData['start_date']) && $requestData['start_date']) {
            $start_date = date('Y-m-d',strtotime($requestData['start_date']));
        }
        if (isset($requestData['end_date']) && $requestData['end_date']) {
            $end_date = date('Y-m-d',strtotime($requestData['end_date']));
        }
        if (isset($requestData['tax_code']) && $requestData['tax_code']) {
            $tax_code = $requestData['tax_code'];
        }
        if (isset($requestData['claim_type']) && $requestData['claim_type']) {
            $claim_type = $requestData['claim_type'];
        }
        if (isset($requestData['claim_reason']) && $requestData['claim_reason']) {
            $claim_reason = $requestData['claim_reason'];
        }
        if (isset($requestData['unit_of_measure']) && $requestData['unit_of_measure']) {
            $unit_of_measure = $requestData['unit_of_measure'];
        }
        if (isset($requestData['client_ref_num']) && $requestData['client_ref_num']) {
            $client_ref_num = $requestData['client_ref_num'];
        }
        $form_param = '{
                "ref_doc_no":"'.$client_ref_num.'",
                "service_agreement":'.$service_booking_id.',
                "product_category":"'.$product_category.'",
                "product_category_item":"'.$product_category_item.'",
                "participant":'.$participant.',
                "claimed_amount":'.$claimed_amount.',
                "quantity":'.$quantity.',
                "tax_code":"'.$tax_code.'",
                "claim_type":"'.$claim_type.'",
                "claim_reason":"'.$claim_reason.'",
                "start_date":"'.$start_date.'",
                "end_date":"'.$end_date.'",
                "unit_of_measure":"'.$unit_of_measure.'"
            }';

        $data = $this->ndis->createPaymentRequest($form_param);

        if (isset($data['code']) && $data['code'] == 200) {
            return response($data['result'])->header('Content-Type', 'application/json');
        } else if(isset($data['errors']) && $data['errors']) {
            return response($data['errors'])->header('Content-Type', 'application/json');
        } else {
            return response($data['result'])->header('Content-Type', 'application/json');
        }
    }

    /**
     * Get Payment Details.
     *
     */
    public function getPaymentDetails(Request $request) {
        $data = $this->ndis->getPaymentDetails($request->all());
        if (isset($data['code']) && $data['code'] == 200) {
            return response($data['result'])->header('Content-Type', 'application/json');
        } else if(isset($data['errors']) && $data['errors']) {
            return response($data['errors'])->header('Content-Type', 'application/json');
        } else {
            return response($data['result'])->header('Content-Type', 'application/json');
        }
    }

    /**
     * Delete Logs.
     *
     */
    public function deleteLogsCron() {
        return $this->common->deleteLogsCron();
    }
}