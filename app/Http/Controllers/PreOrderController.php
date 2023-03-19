<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PreOrderController extends Controller
{
    
    public function index()
    {
        return view('PreOrder');
    }

    public function CreateInvoice(Request $request)
    {
        
        $contadorProductos = 0;
        $products = array();
        $subtotal=0;
        $grandTotal=0;
        while ($request->has("product_name" . ++$contadorProductos)) {
            $product = [
                "product_name" => $request->input("product_name{$contadorProductos}"),
                "product_quantity" => $request->input("product_quantity{$contadorProductos}"),
                "product_price" => $request->input("product_price{$contadorProductos}"),
                "product_Total" => floatval($request->input("product_price{$contadorProductos}")) * $request->input("product_quantity{$contadorProductos}"),

            ];
            $products[] = $product;
            $subtotal+=$product["product_Total"];
        }
     

        $data = [
            'document_type' => strtoupper($request->input('document_type')),
            'date'=>date('d/m/Y', strtotime($request->input('date'))) ,
            'invoiceNro'=> $request->input('invoiceNro'),
            'Attn'=> $request->input('Attn'),
            'AttnEmail'=> $request->input('AttnEmail'),
            'customerName' => $request->input('name'),
            'customerNdis' => $request->input('ndis'),
            'customerDob' =>date('d/m/Y', strtotime($request->input('dob'))) ,
            'customerStreetName' => $request->input('streetname'),
            'customerSuburb' => $request->input('suburb'),
            'customerPostcode' => $request->input('postcode'),


            'customerPhone' => $request->input('phone'),


            'paymentAcct' => $request->input('acct'),
            'paymentBsb' => $request->input('bsb'),
            'paymentAcctName' => $request->input('acctName'),
            'products' => $products,
            'subtotal' =>$subtotal,
            'shippingAndHandling' => $request->input('ShippingAndHandling'),
            'Gst' => $request->input('Gst'),
            'grandTotal'=>$subtotal+floatval($request->input('ShippingAndHandling'))



        ];
     
        $pdf = PDF::loadView('invoice2', $data);
        return $pdf->stream('invoice.pdf');
        // return $pdf->download('invoice.pdf');
        // return View('invoice2', $data);
    }
}
