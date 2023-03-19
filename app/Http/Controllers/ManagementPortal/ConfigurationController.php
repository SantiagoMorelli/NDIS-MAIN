<?php

namespace App\Http\Controllers\ManagementPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\NdisAuthenticationRepository;
use App\Repositories\NdisExternalApiRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\DeviceAuthentication;
use Datatables;
use App\Services\Common;

class ConfigurationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(NdisAuthenticationRepository $ndisAuthentication, NdisExternalApiRepository $ndisExternal) {
        $this->ndisAuthentication = $ndisAuthentication;
        $this->ndisExternal = $ndisExternal;
    }
    
    /**
     * Configuration Device.
     *
     */
    public function configurationDetails(Request $request) {
        /*if(request()->ajax()) {
            return datatables()->of(DeviceAuthentication::select('*'))
            ->addColumn('check_device_expiry', function ($row){
                $convertAustralianTime = Common::dateUTCToClientTZ('Y-m-d H:i:s',time(),false,'Australia/Sydney');
                $currentDateTime = $convertAustralianTime->format('Y-m-d H:i:s');
                $timestamp1 = strtotime($currentDateTime);
                $timestamp2 = strtotime($row['device_expiry']);

                if ($timestamp1 > $timestamp2) {
                    return 1;
                }
                return 0;               
            })
            ->addColumn('check_key_expiry', function ($row){
                $convertAustralianTime = Common::dateUTCToClientTZ('Y-m-d H:i:s',time(),false,'Australia/Sydney');
                $currentDateTime = $convertAustralianTime->format('Y-m-d H:i:s');
                $timestamp1 = strtotime($currentDateTime);
                $timestamp2 = strtotime($row['key_expiry']);

                if ($timestamp1 > $timestamp2) {
                    return 1;
                }
                return 0;               
            })
            ->addColumn('check_expiry', function ($row){
                if (time() > strtotime($row['token_expiry'])) {
                    return 1;
                }
                return 0;               
            })
            ->make(true);
        }*/

        $deviceData = DeviceAuthentication::select('device_expiry','key_expiry','token_expiry')->first();
        if ($deviceData) {
            $deviceData = $deviceData->toArray();
        }
        return View('admin.configuration')->with(['deviceData' => $deviceData]);
    }

    /**
     * Activate Device.
     *
     */
    public function activateDevice(Request $request) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->ndisAuthentication->activateDevice($request->all());
            if (isset($data['code']) && $data['code'] == 200) {
                return redirect(route('configuration'))->with('success','Device Activation successfully.');
            } else if(isset($data['errors']) && $data['errors']) {
                return redirect(route('activateDevice'))->with('error','Something went wrong!');
            } else {
                return redirect(route('configuration'))->with('success','Device Activation successfully.');
            }
        }
        return View('admin.activate_device');
    }

    /**
     * Manually Refresh Device.
     *
     */
    public function manuallyRefreshDevice() {
        $data = $this->ndisAuthentication->refreshDevice();
        if (isset($data['code']) && $data['code'] == 200) {
            return redirect(route('configuration'))->with('success','Refresh Device successfully.');
        } else if(isset($data['errors']) && $data['errors']) {
            return redirect(route('configuration'))->with('error','Something went wrong!');
        } else {
            return redirect(route('configuration'))->with('success','Refresh Device successfully.');
        }
    }

    /**
     * Reference Data.
     *
     */
    public function referenceData() {
        if(request()->ajax()) {
            $referenceData = [];
            $data = $this->ndisExternal->getReferenceData();
            if (isset($data['result'])) {
                $jData = json_decode($data['result'],true);
                if (isset($jData['result'])) {
                    $referenceData = $jData['result'];
                }
            }

            return datatables()->of($referenceData)
            ->make(true);
        }
        
        return View('admin.reference_data');
    }

    /**
     * Plan Details.
     *
     */
    public function planDetails() {
        $requestData['participant'] = 430395973;
        $requestData['participant_surname'] = 'Adolf';
        $requestData['date_of_birth'] = "1991-11-11";
        if(request()->ajax()) {
            $planData = [];
            $data = $this->ndisExternal->getParticipantPlan($requestData);
            if (isset($data['result'])) {
                $jData = json_decode($data['result'],true);
                if (isset($jData['result'])) {
                    $planData = $jData['result'];
                }
            }

            return datatables()->of($planData)
            ->make(true);
        }
        
        return View('admin.plan_details');
    }
}