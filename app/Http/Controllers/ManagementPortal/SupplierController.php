<?php

namespace App\Http\Controllers\ManagementPortal;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAllSuppliers(Request $request)
    {
        //
        
        $data = Supplier::select('supplier_id','supplier_name','contact_person','phone_number','supplier_emailid')->distinct()->get()->toArray();
        return datatables()->of($data)
        ->addColumn('action', function($row) {
            if(isset($row['supplier_name'])){

                return '<button class="btn"> <a href='.route('viewOneSupplier',['supplierName'=>$row['supplier_name']]).'> View </a></button>
                        <button class="btn dropdown-toggle btn-primary shadow-sm btn-xs mr-2 py-0" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">Email </button>
                        <div>
                            <div class="dropdown-menu relative bottom-10" style="z-index:1000000;" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="'. route('emailSupplierPage',['supplier_id' => $row['supplier_id']]).'" >Manual Email</a>
                                <a class="dropdown-item" href="'. route('emailSupplierETAPage',['supplier_id' => $row['supplier_id']]).'" >Email for: Requesting ETA details</a>
                            </div>
                        </div>';
            }
            return null;
        })
        ->make(true);
    }

    public function allSuppliersPage()
    {
        //
            return View('admin.supplier.all_supplier');
           
     
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function getOrderSupplier($orderNumber)
    {
        //
        

            //$data = Supplier::where('order_id',$orderNumber)->distinct()->get()->toArray();
           // $data = Supplier::where('order_id',$orderNumber)->get()->toArray();

            $data = Supplier::select('supplier_id','order_id','supplier_name','invoice_number','supplier_emailid','record_number')->distinct()->where('order_id',intval($orderNumber))->groupBy('supplier_id')->get()->toArray();
           // print_r($data);
            return datatables()->of($data)
            ->addColumn('invoice_number',function($row){
            return $row['invoice_number']?$row['invoice_number']:null;
            })
            ->addColumn('action', function($row) {
                if(isset($row['supplier_name'])){
    
                    return '<button class="btn dropdown-toggle btn-primary shadow-sm btn-xs mr-2 py-0" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                             Email 
                            </button> 
                            <div>
                            <div class="dropdown-menu relative bottom-10" style="z-index:1000000;" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="'. route('emailSupplierOrderUpdatePage',['supplier_id' => $row['supplier_id'],'orderNumber'=> $row['order_id'] ]).'" >Email for: Order updates</a>
                                <a class="dropdown-item" href="'. route('emailSupplierTrackingPage',['supplier_id' => $row['supplier_id'],'orderNumber'=> $row['order_id']]).'" >Email for: Requesting tracking details</a>
                                <a class="dropdown-item" href="'. route('emailSupplierChangeOrderPage',['supplier_id' => $row['supplier_id'] ,'orderNumber'=> $row['order_id']]).'" >Email for: Change order</a>
                            </div>
                        </div>';
                }
                return null;
            })
            
            ->make(true);
     
    }

    public function editSupplierPage($supplierName='')
    {


            $supplierData = Supplier::where('supplier_name', $supplierName)->first();
            if (!$supplierData) {
                return redirect(route('getOrders'));
            }
       
        
        return View('admin.supplier.edit_supplier')->with('supplierData',$supplierData);
     
    }

    public function editSupplier($supplierName='', Request $request)
    {
        $requestData=$request->all();
        
        try{
            Supplier::where('supplier_name',$supplierName)->update([
                'supplier_emailid'=>$requestData["supplier_emailid"],
                'phone_number'=>$requestData["phone_number"],
                'contact_person'=>$requestData["contact_person"],
                'note'=>$requestData['note']]);
        }catch(Exception $e){
            return redirect(route('getSuppliersPage'))->with('error','Please try again'.$e->getMessage());
        }
            
        return redirect(route('getSuppliersPage'))->with('success','successfully updated supplier information!');
       
            
     
    }
    public function viewOneSupplier($supplierName){
        // dd($supplierName);
        $supplier=Supplier::where('supplier_name',$supplierName)->first();
        if($supplier){
            return View('admin.supplier.view_one_supplier',['supplier'=>$supplier]);
        }
        redirect(route("getTicketsPage"))->with('error','No supplier');


    }

    public function addSupplierInvoice(Request $request, $orderNumber){
        $requestData = $request->all();
        try{
            Supplier::where('order_id',$orderNumber)->where('record_number',$requestData['record_number'])->update([
                'invoice_number'=>$requestData['invoice_number']]);
        }catch(Exception $e){
            return redirect(route('viewOrderDetails', ['id'=> $orderNumber]))->with('error','Please try again'.$e->getMessage());
        }
            
        return redirect( route('viewOrderDetails', ['id' => $orderNumber]))->with('success','successfully added supplier invoice number!');
       
    }


    
}
