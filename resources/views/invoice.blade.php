<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Tax Invoice</title>
    <style>
        table,
        tr,
        td {
            padding: 10px;
        }
    </style>
</head>

<body>
    <table>
        <tbody>
            <tr>
                <td width="50%" style="padding-right: 30px !important;">
                    <table cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td style="text-align: center;">
                                    <img src="{{ asset('assets/images/logo.svg') }}" width="200px" />
                                    <div style="font-size: 18px;font-weight: 400;text-align: center;"><span
                                            style="color: #c1d743;">better</span><span
                                            style="color: #1b3664;">care</span><span
                                            style="color: #c1d743;">market</span></div>
                                    <i style="color: #304a77; letter-spacing: 3px;text-align: center;font-size: 15px;">Reimagine
                                        Better Living</i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br />
                    <br />
                </td>

                <td width="50%">
                    <table cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td colspan="2"><b
                                        style="font-size: 46.3px;letter-spacing: 3px;color: #304a77;font-family: Oswald;width: 100%">INVOICE</b>
                                </td>
                            </tr>
                            <tr>
                                <td><b style="color: #304a77;">DATE:</b></td>
                                <td style="color: #2a2a28;">{{ date('d/m/Y', strtotime($order_date)) }}</td>
                            </tr>
                            <tr>
                                <td><b style="color: #304a77;">INVOICE NO:</b></td>
                                <td style="color: #2a2a28;">{{ $invoice_no }}</td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2"><b style="color: #304a77;font-size: 22.5px;">To
                                        {{ $plan_manager_name }}</b></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <p style="color: #304a77;">{{ $invoice_email_address }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <p style="border-bottom: 2px solid #c1d946;margin-top: 0px;"></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <table>
        <tbody>
            <tr>
                <td width="50%">
                    <table cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td>
                                    <h3 style="letter-spacing: 3px;color: #304a77;margin-top: 0px !important;">PAYMENT
                                        METHOD</h3>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 40%;font-weight: 10px;">ACCT NO: </td>
                                <td style="width: 65%;color: #2a2a28">{{ $account_no }}</td>
                            </tr>
                            <tr>
                                <td style="width: 40%;">BSB: </td>
                                <td style="width: 65%;color: #2a2a28">{{ $bsb }}</td>
                            </tr>
                            <tr>
                                <td style="width: 40%;">ACCT NAME: </td>
                                <td style="width: 65%;color: #2a2a28">{{ $account_name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>

                <td width="50%">
                    <table cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td>
                                    <h3 style="letter-spacing: 3px;color: #304a77;margin-top: 0px !important;">CUSTOMER
                                        DETAILS</h3>
                                </td>
                            </tr>
                            <tr>
                                <td width="35%" style="color: #304a77;">Name: </td>
                                <td style="width: 65%;color: #2a2a28">{{ $ndis_participant_name }}</td>
                            </tr>
                            <tr>
                                <td width="35%" style="color: #304a77;">NDIS No: </td>
                                <td style="width: 65%;color: #2a2a28">{{ $ndis_participant_number }}</td>
                            </tr>
                            <tr>
                                <td width="35%" style="color: #304a77;">DoB: </td>
                                <td style="width: 65%;color: #2a2a28">
                                    {{ date('d/m/Y', strtotime($ndis_participant_date_of_birth)) }}</td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <td width="35%" style="color: #304a77;">Address: </td>
                                <td style="width: 65%;color: #2a2a28">{{ $billing_address_street }}@if ($billing_address_city)
                                        ,
                                    @endif
                                    <br />
                                    {{ $billing_address_city }}@if ($billing_address_state)
                                        ,
                                    @endif
                                    <br />
                                    {{ $billing_address_state }}@if ($billing_address_post_code)
                                        , {{ $billing_address_post_code }}
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    <table>
        <thead style="margin: 0px !important;padding: 0px !important;">
            <tr
                style="font-weight:bold;background-color: #1d3563;color: white;text-align: center;margin: 0px;padding: 0px;">
                <th width="50%">PRODUCT NAME</th>
                <th width="10%">QTY</th>
                <th width="15%">PRICE</th>
                <th width="10%">GST</th>
                <th width="15%">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 0 @endphp
            @foreach ($product_items as $itemVal)
                <tr @if ($i % 2 == 0) style="background-color: #e0eba3;" @endif>
                    <td width="50%">{{ $itemVal['item_name'] }}</td>
                    <td width="10%" style="text-align: center;">{{ $itemVal['item_quantity'] }}</td>
                    <td width="15%" style="text-align: center;">${{ number_format($itemVal['item_price'], 2) }}</td>
                    <td width="10%" style="text-align: center;">
                        @if ($itemVal['gst'] > 0)
                            ${{ number_format($itemVal['gst'], 2) }}
                        @else
                            --
                        @endif
                    </td>
                    <td width="15%" style="text-align: center;">@php echo '$'.number_format(($itemVal['item_quantity'] * $itemVal['item_price']),2); @endphp</td>
                </tr>
                @php $i++; @endphp
            @endforeach
        </tbody>
    </table>

    <table cellpadding="0" cellspacing="0">
        <thead></thead>
        <tbody>
            <tr>
                <td>
                    <p style="border-bottom: 3px solid #c1d946;margin-top: 0px;"></p>
                </td>
            </tr>
            <tr>
                <td style="width: 88%;text-align: right;">Subtotal</td>
                <td style="width: 12%;text-align: right;padding-left: 20px;">
                    @if (isset($product_total))
                        ${{ number_format($product_total, 2) }}
                    @else
                        --
                    @endif
                </td>
            </tr>
            @if (isset($order_discount) && $order_discount > 0)
                <tr>
                    <td style="width: 88%;text-align: right;">Discount</td>
                    <td style="width: 12%;text-align: right;padding-left: 20px;"> -
                        ${{ number_format($order_discount, 2) }}</td>
                </tr>
            @endif
            <tr>
                <td style="width: 88%;text-align: right;">Shipping & Handling</td>
                <td style="width: 12%;text-align: right;padding-left: 20px;">
                    @if (isset($shipping_total))
                        ${{ number_format($shipping_total, 2) }}
                    @else
                        --
                    @endif
                </td>
            </tr>
            <tr>
                <td style="width: 88%;text-align: right;">10% GST</td>
                <td style="width: 12%;text-align: right;padding-left: 20px;">
                    @if (isset($gst_total))
                        ${{ number_format($gst_total, 2) }}
                    @else
                        -
                    @endif
                </td>
            </tr>

            <tr>
                <td style="width: 88%;text-align: right;"><b>GRAND TOTAL</b></td>
                <td style="width: 12%;text-align: right;padding-left: 20px;"><b>
                        @if (isset($order_total))
                            ${{ number_format($order_total, 2) }}
                        @else
                            --
                        @endif
                    </b></td>
            </tr>
        </tbody>
    </table>
    <table cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td width="72%">
                    <table cellpadding="1" cellspacing="0">
                        <tbody>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Once we have received the full amount of <b>${{ $order_total }} </b>in our bank
                                    account, we will process the order.</td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b style="color: #c1d946;">Questions?</b></td>
                            </tr>
                            <tr>
                                <td>Email us at customercare@bettercaremarket.com.au</td>
                            </tr>
                            <tr>
                                <td>or call us at 1300 172 151</td>
                            </tr>
                            <tr>
                                <td><a style="color: #304a77" href="{{ $website }}">{{ $website }}</a></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td width="28%">
                    <table cellpadding="1" cellspacing="0">
                        <tbody>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b
                                        style="font-size: 30.9px;letter-spacing: 2px;color: #c1d946;font-family: Oswald;width: 100%;text-align: right;">THANK</b>
                                </td>
                            </tr>
                            <tr>
                                <td><b
                                        style="font-size: 30.9px;letter-spacing: 2px;color: #c1d946;font-family: Oswald;width: 100%;text-align: right;">YOU!</b>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
