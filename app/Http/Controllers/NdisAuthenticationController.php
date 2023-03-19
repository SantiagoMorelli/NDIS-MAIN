<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\NdisAuthenticationRepository;

class NdisAuthenticationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(NdisAuthenticationRepository $ndisAuthentication) {
        $this->ndisAuthentication = $ndisAuthentication;
    }
    
    /**
     * Activate Device.
     *
     */
    public function activateDevice(Request $request) {
        $data = $this->ndisAuthentication->activateDevice($request->all());
        if (isset($data['code']) && $data['code'] == 200) {
            return response($data['result'])->header('Content-Type', 'application/json');
        } else if(isset($data['errors']) && $data['errors']) {
            return response($data['errors'])->header('Content-Type', 'application/json');
        } else {
            return response($data['result'])->header('Content-Type', 'application/json');
        }
    }

    /**
     * Refresh Device.
     *
     */
    public function refreshDevice(Request $request) {
        $data = $this->ndisAuthentication->refreshDevice();
        if (isset($data['code']) && $data['code'] == 200) {
            return response($data['result'])->header('Content-Type', 'application/json');
        } else if(isset($data['errors']) && $data['errors']) {
            return response($data['errors'])->header('Content-Type', 'application/json');
        } else {
            return response($data['result'])->header('Content-Type', 'application/json');
        }
    }

    /**
     * Authenticate Software.
     *
     */
    public function authenticateSoftwareInstance() {
        $data = $this->ndisAuthentication->authenticateSoftwareInstance();
        if (isset($data['code']) && $data['code'] == 200) {
            return response($data['result'])->header('Content-Type', 'application/json');
        } else if(isset($data['errors']) && $data['errors']) {
            return response($data['errors'])->header('Content-Type', 'application/json');
        } else {
            return response($data['result'])->header('Content-Type', 'application/json');
        }
    }

    /**
     * Refresh Device Cron.
     *
     */
    public function refreshDeviceCron() {
        return $this->ndisAuthentication->refreshDeviceCron();
    }

    /**
     * Manual Device Activation Cron.
     *
     */
    public function manualDeviceActivationCron() {
        return $this->ndisAuthentication->manualDeviceActivationCron();
    }
    
}