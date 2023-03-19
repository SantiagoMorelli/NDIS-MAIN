<?php 
namespace App\Repositories;

use App\Models\JwkData;
use App\Models\DeviceAuthentication;
use Illuminate\Http\Response;
use App\Repositories\CommonRepository;
use App\Services\Api;
use App\Services\Common;

class NdisAuthenticationRepository
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CommonRepository $common) {
        $this->common = $common;
    }

	/**
     * Activate Device.
     *
     */
    public function activateDevice($requestData = []) {
        $createJwk = $this->common->createJwk();
        $url = config('ndis.activate.activationURL').config('ndis.activate.deviceId').config('ndis.activate.activationURLEnd');

        $messageId = $this->common->uuid();
        $correlationId = $this->common->uuid();

        $headers = array(
            'Content-Type: application/json',
            'dhs-auditId: '.config('ndis.refresh.proda_ra'),
            'dhs-auditIdType: '.config('ndis.dhs.auditIdType'),
            'dhs-subjectId: '.config('ndis.activate.deviceId'),
            'dhs-subjectIdType: '.config('ndis.dhs.subjectIdType'),
            'dhs-messageId: '.$messageId,
            'dhs-correlationId: '.$correlationId,
            'dhs-productId: '.config('ndis.dhs.productId'),
        );
        
        $jwk = '';
        $getJwkData = JwkData::first();
        if ($getJwkData) {
            $getJwkDataArray = $getJwkData->toArray();
            $jwk = $this->common->encrypt_decrypt($getJwkDataArray['jwk'],'decrypt');
        }

        $activationCode = config('ndis.activate.activationCode');
        if (isset($requestData['activation_code']) && $requestData['activation_code']) {
            $activationCode = $requestData['activation_code'];
        }
        $form_params =  '{
                "orgId": "'.config('ndis.activate.organizationId').'",
                "otac": "'.$activationCode.'",
                "key": '.$jwk.'
            }';

        $logsData['name']      = 'Activate Device';
        $logsData['url']       = $url;
        $logsData['headers']   = json_encode($headers,true);
        $logsData['method']    = 'PUT';
        $logsData['payload']   = $form_params;
        // store log
        $storeLogId = $this->common->storeLogs($logsData);

        $data = Api::callCURL($url, $headers, $form_params, "PUT");

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

        if (isset($data['code']) && ($data['code'] == 200 || $data['code'] == 201 )) {
            $this->authenticateSoftwareInstance();
        }
        return $data;
    }

    /**
     * Refresh Device.
     *
     */
    public function refreshDevice($requestData = []) {

        $url = config('ndis.refresh.refreshUrl').config('ndis.refresh.proda_ra').config('ndis.refresh.refreshUrlMiddle').config('ndis.activate.deviceId').config('ndis.refresh.refreshUrlEnd');

        $checkToken = $this->common->checkAccessTokenExpiry();
        if ($checkToken) {
            $this->authenticateSoftwareInstance();
        }
        $bearerToken = '';
        $deviceAuth = DeviceAuthentication::get()->first();
        if ($deviceAuth) {
            $accessToken = $this->common->encrypt_decrypt($deviceAuth->access_token,'decrypt');
            $bearerToken = 'Bearer '.$accessToken;
        }

        $messageId = $this->common->uuid();
        $correlationId = $this->common->uuid();

        $headers = array(
            'Authorization: '.$bearerToken,
            'Content-Type: application/json',
            'dhs-auditId: '.config('ndis.refresh.proda_ra'),
            'dhs-auditIdType: '.config('ndis.dhs.auditIdType'),
            'dhs-subjectId: '.config('ndis.activate.deviceId'),
            'dhs-subjectIdType: '.config('ndis.dhs.subjectIdType'),
            'dhs-messageId: '.$messageId,
            'dhs-correlationId: '.$correlationId,
            'dhs-productId: '.config('ndis.dhs.productId'),
        );
        
        $jwk = $this->common->createJwk();
        $form_params = $jwk;

        $logsData['name']      = 'Refresh Device';
        $logsData['url']       = $url;
        $logsData['headers']   = json_encode($headers,true);
        $logsData['method']    = 'PUT';
        $logsData['payload']   = $form_params;
        // store log
        $storeLogId = $this->common->storeLogs($logsData);

        $data = Api::callCURL($url, $headers, $form_params, "PUT");

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

        if (isset($data['code']) && $data['code'] == 200) {
            $this->authenticateSoftwareInstance();
        }
        return $data;
    }

    /**
     * Authenticate Software.
     *
     */
    public function authenticateSoftwareInstance() {
        $jwtToken = '';
        $getJwkData = JwkData::first();
        if ($getJwkData) {
            $getJwkDataArray = $getJwkData->toArray();
            if ($getJwkDataArray['jwt_token']) {
                $jwtToken = $this->common->encrypt_decrypt($getJwkDataArray['jwt_token'],'decrypt');
            } else {
                if ($getJwkDataArray['jwk_private']) {
                    $jwkPrivate = $this->common->encrypt_decrypt($getJwkDataArray['jwk_private'],'decrypt');
                    $token = $this->common->createJwtToken(json_decode($jwkPrivate,true));
                    if ($token) {
                        $getJwkData->jwt_token = $this->common->encrypt_decrypt($token);
                        $getJwkData->save();
                        $jwtToken = $token;
                    }
                }
            }
        }

        $url = config('ndis.auth.authenticate_URL');
        $headers = array('Content-Type: application/x-www-form-urlencoded');

        $form_params = "client_id=".config('ndis.auth.clientId')."&grant_type=".config('ndis.auth.grantType')."&assertion=".$jwtToken;

        $logsData['name']      = 'Authenticate Software Instance';
        $logsData['url']       = $url;
        $logsData['headers']   = json_encode($headers,true);
        $logsData['method']    = 'POST';
        $logsData['payload']   = $form_params;
        // store log
        $storeLogId = $this->common->storeLogs($logsData);

        $data = Api::callCURL($url, $headers, $form_params, "POST");

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

        if (isset($data['code']) && $data['code'] == 200) {
            $authData = json_decode($data['result'],true);
            if ($authData) {
                $defaultTimezone = date_default_timezone_get();
                date_default_timezone_set('UTC');
                $deviceAuth = DeviceAuthentication::get()->first();
                if ($deviceAuth) {
                    if (isset($authData['access_token']) && $authData['access_token']) {
                        $deviceAuth->access_token = $this->common->encrypt_decrypt($authData['access_token'],'encrypt');
                    }
                    if (isset($authData['expires_in']) && $authData['expires_in']) {
                        $deviceAuth->token_expiry = date("Y-m-d H:i:s", strtotime('+'.$authData['expires_in'].' seconds'));
                        $deviceAuth->expires_in = $authData['expires_in'];
                    }
                    if (isset($authData['device_expiry']) && $authData['device_expiry']) {
                        $deviceAuth->device_expiry = $authData['device_expiry'];
                    }
                    if (isset($authData['key_expiry']) && $authData['key_expiry']) {
                        $deviceAuth->key_expiry = $authData['key_expiry'];
                    }
                    if (isset($authData['token_type'])) {
                        $deviceAuth->token_type = $authData['token_type'];
                    }
                    if (isset($authData['scope'])) {
                        $deviceAuth->scope = $authData['scope'];
                    }
                    $deviceAuth->save();
                } else {
                    $deviceAuth = new DeviceAuthentication();
                    if (isset($authData['access_token']) && $authData['access_token']) {
                        $deviceAuth->access_token = $this->common->encrypt_decrypt($authData['access_token'],'encrypt');
                    }
                    if (isset($authData['expires_in']) && $authData['expires_in']) {
                        $deviceAuth->token_expiry = date("Y-m-d H:i:s", strtotime('+'.$authData['expires_in'].' seconds'));
                        $deviceAuth->expires_in = $authData['expires_in'];
                    }
                    if (isset($authData['device_expiry']) && $authData['device_expiry']) {
                        $deviceAuth->device_expiry = $authData['device_expiry'];
                    }
                    if (isset($authData['key_expiry']) && $authData['key_expiry']) {
                        $deviceAuth->key_expiry = $authData['key_expiry'];
                    }
                    if (isset($authData['token_type'])) {
                        $deviceAuth->token_type = $authData['token_type'];
                    }
                    if (isset($authData['scope'])) {
                        $deviceAuth->scope = $authData['scope'];
                    }
                    $deviceAuth->save();
                }
                date_default_timezone_set($defaultTimezone);
            }
        }
        return $data;
    }

    /**
     * Refresh Device Cron.
     *
     */
    public function refreshDeviceCron() {
        $deviceAuth = DeviceAuthentication::first();
        if ($deviceAuth) {
            if (isset($deviceAuth->key_expiry) && $deviceAuth->key_expiry) {
                $keyExpiry = date('Y-m-d H:i:s',strtotime($deviceAuth->key_expiry));
            }
            $convertAustralianTime = Common::dateUTCToClientTZ('Y-m-d H:i:s',time(),false,'Australia/Sydney');
            $currentDateTime = $convertAustralianTime->format('Y-m-d H:i:s');
            $timestamp1 = strtotime($currentDateTime);
            $timestamp2 = strtotime($keyExpiry);
            if ($timestamp1 > $timestamp2) {
                $data =  $this->refreshDevice();
                if (isset($data['code']) && ($data['code'] == 200 || $data['code'] == 201)) {
                    return 'Refresh Device Cron Run Successfully, Refresh Device Key Successfully.';
                } else {
                    return $data;
                }
            } else {
                $hour = abs($timestamp2 - $timestamp1)/(60*60);
                if ($hour <= 48) {
                    $data =  $this->refreshDevice();
                    if (isset($data['code']) && ($data['code'] == 200 || $data['code'] == 201)) {
                        return 'Refresh Device Cron Run Successfully, Refresh Device Key Successfully.';
                    } else {
                        return $data;
                    }
                }
            }
            return 'Refresh Device Cron Run Successfully, Key was not expired.';
        }
        return 'Refresh Device Cron Run Failed.';
    }

    /**
     * Manual Device Activation Cron.
     *
     */
    public function manualDeviceActivationCron() {
        $deviceAuth = DeviceAuthentication::first();
        if ($deviceAuth) {
            if (isset($deviceAuth->device_expiry) && $deviceAuth->device_expiry) {
                $deviceExpiry = date('Y-m-d',strtotime($deviceAuth->device_expiry));
            }
            $convertAustralianTime = Common::dateUTCToClientTZ('Y-m-d H:i:s',time(),false,'Australia/Sydney');
            $currentDateTime = $convertAustralianTime->format('Y-m-d');
            $timestamp1 = strtotime($currentDateTime);
            $timestamp2 = strtotime($deviceExpiry);
            if ($timestamp1 > $timestamp2) {
                
            } else {
                $datediff = $timestamp2 - $timestamp1;
                $days = round($datediff / (60 * 60 * 24));

                if ($days <= 30) {
                    if ($days == 30) {
                        $details['days'] = $days;
                        $email = config('ndis.admin_email');
                        try {
                            \Mail::send('notification', $details, function ($message) use ($email) {
                                $message->to($email)->subject('Manual Device Activation Notification');
                            });
                        } catch (\Exception $exception){
                            \Log::info($exception->getMessage());
                        }
                    } else if ($days <= 7 ) {
                        $details['days'] = $days;
                        $email = config('ndis.admin_email');
                        try {
                            \Mail::send('notification', $details, function ($message) use ($email) {
                                $message->to($email)->subject('Manual Device Activation Notification');
                            });
                        } catch (\Exception $exception){
                            \Log::info($exception->getMessage());
                        }
                    }
                }
            }
        return 'Manual Device Activation Cron Run Successfully.';
        }
        return 'Manual Device Activation Cron Failed.';
    }
}