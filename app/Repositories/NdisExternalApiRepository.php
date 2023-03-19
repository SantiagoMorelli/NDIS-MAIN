<?php 
namespace App\Repositories;

use Illuminate\Http\Response;
use App\Repositories\CommonRepository;
use App\Repositories\NdisAuthenticationRepository;
use App\Services\Api;
use App\Models\DeviceAuthentication;

class NdisExternalApiRepository
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CommonRepository $common,NdisAuthenticationRepository $ndisAuthentication) {
        $this->common = $common;
        $this->ndisAuthentication = $ndisAuthentication;
    }

	/**
     * Get Participant Plan Details.
     *
     */
    public function getParticipantPlan($requestData = []) {
        $participant = $participant_surname = $date_of_birth = '';
        if (isset($requestData['participant'])) {
            $participant = $requestData['participant'];
        }

        if (isset($requestData['participant_surname'])) {
            $participant_surname = $requestData['participant_surname'];
        }

        if (isset($requestData['date_of_birth'])) {
            $date_of_birth = $requestData['date_of_birth'];
        }

        $url = config('ndis.hostUrl').config('ndis.planUrl').'?participant='.$participant.'&participant_surname='.$participant_surname.'&date_of_birth='.$date_of_birth;

        $checkToken = $this->common->checkAccessTokenExpiry();
        if ($checkToken) {
            $this->ndisAuthentication->authenticateSoftwareInstance();
        }
        $bearerToken = '';
        $deviceAuth = DeviceAuthentication::get()->first();
        if ($deviceAuth) {
            $accessToken = $this->common->encrypt_decrypt($deviceAuth->access_token,'decrypt');
            $bearerToken = 'Bearer '.$accessToken;
        }

        $headers = array(
            'accept: application/json',
            'Authorization: '.$bearerToken,
            'x-ibm-client-id: '.config('ndis.x_ibm_client_id'),
        );

        $logsData['name']      = 'Retrieve Participant Plans';
        $logsData['url']       = $url;
        $logsData['headers']   = json_encode($headers,true);
        $logsData['method']    = 'GET';
        // store log
        $storeLogId = $this->common->storeLogs($logsData);

        $data = Api::callCURL($url, $headers, [], "GET");

        if ($storeLogId) {
            $logsData['id'] = $storeLogId;
        }

        $response = $data;
        if (is_array($data)) {
            $response = json_encode($data,true);
        }
        $logsData['response'] = $response;
        // update log
        $updateLogId = $this->common->storeLogs($logsData);

        return $data;
    }

    /**
     * Get Reference Data.
     *
     */
    public function getReferenceData($requestData = []) {

        if (isset($requestData['attribute_name']) && $requestData['attribute_name']) {
            $url = config('ndis.hostUrl').config('ndis.referenceURL').'/'.$requestData['attribute_name'];
        } else {
            $url = config('ndis.hostUrl').config('ndis.referenceURL');
        }

        $checkToken = $this->common->checkAccessTokenExpiry();
        if ($checkToken) {
            $this->ndisAuthentication->authenticateSoftwareInstance();
        }
        $bearerToken = '';
        $deviceAuth = DeviceAuthentication::get()->first();
        if ($deviceAuth) {
            $accessToken = $this->common->encrypt_decrypt($deviceAuth->access_token,'decrypt');
            $bearerToken = 'Bearer '.$accessToken;
        }

        $headers = array(
            'accept: application/json',
            'Authorization: '.$bearerToken,
            'x-ibm-client-id: '.config('ndis.x_ibm_client_id'),
        );

        $logsData['name']      = 'Retrieve Reference Data';
        $logsData['url']       = $url;
        $logsData['headers']   = json_encode($headers,true);
        $logsData['method']    = 'GET';
        // store log
        $storeLogId = $this->common->storeLogs($logsData);

        $data = Api::callCURL($url, $headers, [], "GET");

        if ($storeLogId) {
            $logsData['id'] = $storeLogId;
        }
        $response = $data;
        if (is_array($data)) {
            $response = json_encode($data);
        }

        $logsData['response'] = $response;
        // update log
        $updateLogId = $this->common->storeLogs($logsData);
        return $data;
    }

    /**
     * Create a new service booking.
     *
     */
    public function createServiceBooking($form_param) {

        $url = config('ndis.hostUrl').config('ndis.serviceBookingUrl');

        $checkToken = $this->common->checkAccessTokenExpiry();
        if ($checkToken) {
            $this->ndisAuthentication->authenticateSoftwareInstance();
        }
        $bearerToken = '';
        $deviceAuth = DeviceAuthentication::get()->first();
        if ($deviceAuth) {
            $accessToken = $this->common->encrypt_decrypt($deviceAuth->access_token,'decrypt');
            $bearerToken = 'Bearer '.$accessToken;
        }

        $headers = array(
            "accept: application/json",
            "authorization: ".$bearerToken,
            "content-type: application/json",
            "x-ibm-client-id: ".config('ndis.x_ibm_client_id')
        );

        $logsData['name']      = 'Create Service Booking';
        $logsData['url']       = $url;
        $logsData['headers']   = json_encode($headers,true);
        $logsData['method']    = 'POST';
        $logsData['payload']   = $form_param;
        // store log
        $storeLogId = $this->common->storeLogs($logsData);

        $data = Api::callCURL($url, $headers, $form_param, "POST");

        if ($storeLogId) {
            $logsData['id'] = $storeLogId;
        }
        $response = $data;
        if (is_array($data)) {
            $response = json_encode($data);
        }

        $logsData['response'] = $response;
        // update log
        $updateLogId = $this->common->storeLogs($logsData);

        return $data;
    }

    /**
     * Update service booking.
     *
     */
    public function updateServiceBooking($requestData = []) {
        $service_booking_id     = $requestData['service_booking_id'];
        $product_category       = $requestData['product_category'];
        $product_category_item  = '';
        if (isset($requestData['product_category_item'])) {
            $product_category_item = $requestData['product_category_item'];
        }
        $quantity               = $requestData['quantity'];
        $price                  = $requestData['price'];
        $booking_type           = config('ndis.booking_type');
        if (isset($requestData['booking_type']) && $requestData['booking_type']) {
            $booking_type = $requestData['booking_type'];
        }

        $url = config('ndis.hostUrl').config('ndis.serviceBookingUrl').$service_booking_id;

        $checkToken = $this->common->checkAccessTokenExpiry();
        if ($checkToken) {
            $this->ndisAuthentication->authenticateSoftwareInstance();
        }
        $bearerToken = '';
        $deviceAuth = DeviceAuthentication::get()->first();
        if ($deviceAuth) {
            $accessToken = $this->common->encrypt_decrypt($deviceAuth->access_token,'decrypt');
            $bearerToken = 'Bearer '.$accessToken;
        }

        $headers = array(
            "accept: application/json",
            "authorization: ".$bearerToken,
            "content-type: application/json",
            "x-ibm-client-id: ".config('ndis.x_ibm_client_id')
        );

        $form_param = '{
            "product_category_item":"'.$product_category_item.'",
            "product_category":"'.$product_category.'",
            "quantity":"'.$quantity.'",
            "booking_type":"'.$booking_type.'",
            "price":"'.$price.'"
        }';

        $logsData['name']      = 'Update Service Booking';
        $logsData['url']       = $url;
        $logsData['headers']   = json_encode($headers,true);
        $logsData['method']    = 'PATCH';
        $logsData['payload']   = $form_param;
        // store log
        $storeLogId = $this->common->storeLogs($logsData);

        $data = Api::callCURL($url, $headers, $form_param, "PATCH");

        if ($storeLogId) {
            $logsData['id'] = $storeLogId;
        }
        $response = $data;
        if (is_array($data)) {
            $response = json_encode($data);
        }

        $logsData['response'] = $response;
        // update log
        $updateLogId = $this->common->storeLogs($logsData);

        return $data;
    }

    /**
     * Get service booking.
     *
     */
    public function getServiceBooking($requestData) {
        $participant        = $requestData['participant'];
        $service_booking_id = '';
        if (isset($requestData['service_booking_id'])) {
            $service_booking_id = $requestData['service_booking_id'];
        }

        $url = config('ndis.hostUrl').config('ndis.serviceBookingUrl').$service_booking_id;

        $checkToken = $this->common->checkAccessTokenExpiry();
        if ($checkToken) {
            $this->ndisAuthentication->authenticateSoftwareInstance();
        }
        $bearerToken = '';
        $deviceAuth = DeviceAuthentication::get()->first();
        if ($deviceAuth) {
            $accessToken = $this->common->encrypt_decrypt($deviceAuth->access_token,'decrypt');
            $bearerToken = 'Bearer '.$accessToken;
        }

        $headers = array(
            "accept: application/json",
            "authorization: ".$bearerToken,
            "participant: ".$participant,
            "x-ibm-client-id: ".config('ndis.x_ibm_client_id')
        );
        $form_param = [];

        $logsData['name']      = 'Retrieve Service Booking';
        $logsData['url']       = $url;
        $logsData['headers']   = json_encode($headers,true);
        $logsData['method']    = 'GET';
        
        // store log
        $storeLogId = $this->common->storeLogs($logsData);

        $data = Api::callCURL($url, $headers, $form_param, "GET");

        if ($storeLogId) {
            $logsData['id'] = $storeLogId;
        }
        $response = $data;
        if (is_array($data)) {
            $response = json_encode($data);
        }

        $logsData['response'] = $response;
        // update log
        $updateLogId = $this->common->storeLogs($logsData);

        return $data;
    }

    /**
     * Delete service booking.
     *
     */
    public function deleteServiceBooking($service_booking_id) {
        $url = config('ndis.hostUrl').config('ndis.serviceBookingUrl').$service_booking_id;

        $checkToken = $this->common->checkAccessTokenExpiry();
        if ($checkToken) {
            $this->ndisAuthentication->authenticateSoftwareInstance();
        }
        $bearerToken = '';
        $deviceAuth = DeviceAuthentication::get()->first();
        if ($deviceAuth) {
            $accessToken = $this->common->encrypt_decrypt($deviceAuth->access_token,'decrypt');
            $bearerToken = 'Bearer '.$accessToken;
        }

        $headers = array(
            "accept: application/json",
            "authorization: ".$bearerToken,
            "x-ibm-client-id: ".config('ndis.x_ibm_client_id')
        );

        $form_param = [];

        $logsData['name']      = 'Delete Service Booking';
        $logsData['url']       = $url;
        $logsData['headers']   = json_encode($headers,true);
        $logsData['method']    = 'DELETE';

        // store log
        $storeLogId = $this->common->storeLogs($logsData);

        $data = Api::callCURL($url, $headers, $form_param, "DELETE");
        if ($storeLogId) {
            $logsData['id'] = $storeLogId;
        }
        $response = $data;
        if (is_array($data)) {
            $response = json_encode($data);
        }

        $logsData['response'] = $response;
        // update log
        $updateLogId = $this->common->storeLogs($logsData);

        return $data;
    }

    /**
     * Create Payment Request.
     *
     */
    public function createPaymentRequest($form_param) {
        $url = config('ndis.hostUrl').config('ndis.paymentUrl');

        $checkToken = $this->common->checkAccessTokenExpiry();
        if ($checkToken) {
            $this->ndisAuthentication->authenticateSoftwareInstance();
        }
        $bearerToken = '';
        $deviceAuth = DeviceAuthentication::get()->first();
        if ($deviceAuth) {
            $accessToken = $this->common->encrypt_decrypt($deviceAuth->access_token,'decrypt');
            $bearerToken = 'Bearer '.$accessToken;
        }

        $headers = array(
            "accept: application/json",
            "authorization: ".$bearerToken,
            "content-type: application/json",
            "x-ibm-client-id: ".config('ndis.x_ibm_client_id')
        );

        $logsData['name']      = 'Create Payment Request';
        $logsData['url']       = $url;
        $logsData['headers']   = json_encode($headers,true);
        $logsData['method']    = 'POST';
        $logsData['payload']   = $form_param;
        // store log
        $storeLogId = $this->common->storeLogs($logsData);

        $data = Api::callCURL($url, $headers, $form_param, "POST");

        if ($storeLogId) {
            $logsData['id'] = $storeLogId;
        }
        $response = $data;
        if (is_array($data)) {
            $response = json_encode($data);
        }

        $logsData['response'] = $response;
        // update log
        $updateLogId = $this->common->storeLogs($logsData);

        return $data;
    }

    /**
     * Get Payment Details.
     *
     */
    public function getPaymentDetails($requestData) {
        $participant    = $requestData['participant'];
        $claim_number   = '';
        if (isset($requestData['claim_number'])) {
            $claim_number   = $requestData['claim_number'];
        }

        $url = config('ndis.hostUrl').config('ndis.paymentUrl').$claim_number;

        $checkToken = $this->common->checkAccessTokenExpiry();
        if ($checkToken) {
            $this->ndisAuthentication->authenticateSoftwareInstance();
        }
        $bearerToken = '';
        $deviceAuth = DeviceAuthentication::get()->first();
        if ($deviceAuth) {
            $accessToken = $this->common->encrypt_decrypt($deviceAuth->access_token,'decrypt');
            $bearerToken = 'Bearer '.$accessToken;
        }

        $headers = array(
            "accept: application/json",
            "authorization: ".$bearerToken,
            "participant: ".$participant,
            "x-ibm-client-id: ".config('ndis.x_ibm_client_id')
        );
        $form_param = [];

        $logsData['name']      = 'Retrieve Payment Request Details';
        $logsData['url']       = $url;
        $logsData['headers']   = json_encode($headers,true);
        $logsData['method']    = 'GET';

        // store log
        $storeLogId = $this->common->storeLogs($logsData);

        $data = Api::callCURL($url, $headers, $form_param, "GET");

        if ($storeLogId) {
            $logsData['id'] = $storeLogId;
        }
        $response = $data;
        if (is_array($data)) {
            $response = json_encode($data);
        }

        $logsData['response'] = $response;
        // update log
        $updateLogId = $this->common->storeLogs($logsData);

        return $data;
    }
}