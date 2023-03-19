<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class testController extends Controller
{
    public function test(Request $request)
    {
        $email = array();
        //   var_dump($email);
        $to_email = array();
        $email_unique = array();
        if ($request->isMethod('post')) {
            $value = $request->json()->all();
            $c = 0;
            if (isset($value['order_items'])) {
                foreach ($value['order_items'] as $ord_val) {

                    $arr = preg_split("/[-,|]+/", $ord_val['product_supplier']);
                    $to_email = trim($arr[2]);
                    // $email['email'] = array_push($email, $to_email);
                    // $c++;
                    $email[] = $to_email;
                }
                //print_r(array_count_values($email));

            }
            // echo implode(" ", $email);

        }
        $email_unique = array_unique($email);
        $arraydata = implode(' ', $email_unique);
        // echo implode(" ", $email_unique);
        // foreach ($email_unique as $va) {
        //     echo $va . "\n";
        // }
        echo $arraydata . "\n";
        // }
        //     // foreach ($email as $val) {
        //     //     echo $val;
        //     // }
        // }
        $details['items'] = array();
        foreach ($email_unique as $val) {
            if (isset($val)) {
                if (isset($value['order_items'])) {
                    foreach ($value['order_items'] as $item) {
                        $ar = preg_split("/[-,|]+/", $item['product_supplier']);
                        if ($val == trim($ar[2])) {
                            // $details['item_name'] = $item['item_name'];
                            // $details['item_quantity'] = $item['item_quantity'];
                            // $details['product_sku'] = $item['product_sku'];
                            // $details['items'] = $item;
                            $details['items'] = array_push($details, $item);
                        }
                    }
                    $data = [
                        "product_items" => $details['items']
                    ];

                    // foreach ($data['product_items'] as $vall) {
                    //     echo  $vall . "\n";
                    // }

                    foreach ($data as $val) {
                        print_r($val) . "\n";
                    }
                }
            }
        }
    }
}

        //             // $cat = implode(',', $details);
        //             //  echo $cat;

        //         }
        //         // $dat = $details['items']->json_decode();
        //         // $data = ['product_items' => $details['items']];
        //         // $it = $details->json()->all();
        //         // echo $ar[2];
        //         foreach ($details as $val) {
        //             print_r($val);
        //         }
        //     }
        // }
        //rints the latest item in array
        // $data = [
        //     "product_items" => $details['items']
        // ];

        // foreach ($data['product_items'] as $vall) {
        //     echo  $vall . "\n";
        // }
        // $data = [
        //     'items' => $details['items']
        // ];

        // foreach ($data as $val) {
        //     print_r(implode(" ", $val)) . "\n";
        // }
        // // print_r(array_count_values($email));



         //for loop to iterate on unique array
            // $orderitems = array();
            // foreach ($em as $va) {
            //     if (isset($va)) {
            //         if (isset($value['order_items'])) {
            //             foreach ($value['order_items'] as $item) {
            //                 $ar = preg_split("/[-,|]+/", $item['product_supplier']);
            //                 // $email_from_split = implode(' ', $ar[2]);
            //                 if (strcmp($va, $ar[2])) {
            //                     echo "hi from loo";
            //                     echo $va;

            //                     $orderitems['orderr'] = array_push($orderitems, $item);
            //                 }
            //             }
            //         }
            //         // $data = [
            //         //     "itmes" => $orderitems,
            //         // ];
            //         // echo "email:" . $va;
            //         // foreach ($data as $or) {
            //         //     print_r($or);
            //         // }
            //     }
            // }



            // print_r($userdata);
            // // die;