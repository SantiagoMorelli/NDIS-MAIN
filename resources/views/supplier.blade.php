<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>New Order</title>
    <style>
        table,
        tr,
        td {
            padding: 0px;
            text-align: left;
        }
    </style>
</head>

<body>

    <p>Good Morning,</p>

    <p>Can we please place an order for, <strong>{{ $customer_firstname }}</strong>
        <strong>{{ $customer_lastname }}</strong> for the purchase of the item(s) below?
    <p>

    <table cellpadding="0" cellspacing="0" width="100%">
        <tbody>

            <tr>
                <td width="25%">
                    <h3 style="letter-spacing: 3px;color: #304a77;margin-top: 0px !important;">Bettercaremarket</h3>
                </td>
                <td></td>
            </tr>
            <tr>
                <td style="color: #304a77;">Order Number: </td>
                <td style="color: #2a2a28">{{ $order_number }}</td>
            </tr>
            <tr>&nbsp;<td></td>
            </tr>
            <tr>
                <td>
                    <h3 style="letter-spacing: 3px;color: #304a77;margin-top: 0px !important;">CUSTOMER DETAILS</h3>
                </td>
                <td></td>
            </tr>
            <tr>
                <td style="color: #304a77;">Name: </td>
                <td style="color: #2a2a28">{{ $shipping_address_first_name }} {{ $shipping_address_last_name }} </td>
            </tr>
            <tr>
                <td style="color: #304a77;">Phone: </td>
                <td style="color: #2a2a28">{{ $contact_phone_number }}</td>
            </tr>


            <tr>&nbsp;<td></td>
            </tr>
            <tr>
                <td>
                    <h3 style="letter-spacing: 3px;color: #304a77;margin-top: 0px !important;">SHIPPING ADDRESS</h3>
                </td>
                <td></td>
            </tr>
            <tr>
                <td style="color: #304a77;">Company: </td>
                <td style="color: #2a2a28">{{ $shipping_address_company }}</td>
            </tr>
            <tr>
                <td style="color: #304a77;">House number & Street: </td>
                <td style="color: #2a2a28">{{ $shipping_address_street }}</td>
            </tr>
            <tr>
                <td style="color: #304a77;">Suburb: </td>
                <td style="color: #2a2a28">{{ $shipping_address_city }}</td>
            </tr>
            <tr>
                <td style="color: #304a77;">State & Postcode: </td>
                <td style="color: #2a2a28">{{ $shipping_address_state }}@if ($shipping_address_post_code)
                        {{ $shipping_address_post_code }}
                    @endif
                </td>
            </tr>


        </tbody>
    </table>


    <p style="letter-spacing: 3px;color: #304a77;margin-top: 0px !important;">Order Details</p>

    <table width="100%">
        <thead style="margin: 0px !important;padding: 0px !important;">
            <tr
                style="font-weight:bold;background-color: #1d3563;color: white;text-align: center;margin: 0px;padding: 0px;">
                <th>SKU</th>
                <th>Name</th>
                <th>Type</th>
                <th>Size</th>
                <th>Colour</th>
                <th>Qty</th>
                <th>Dispatch date or OOS & ETA</th>
                <th>Invoice number</th>
                <th>Courier</th>
                <th>Tracking code</th>
            </tr>
        </thead>
        <tbody>

            @php $i = 0 @endphp
            @foreach ($product_items as $itemVal)
                <tr @if ($i % 2 == 0) style="background-color: #e0eba3;" @endif>
                    <td style="padding-left: 10px">{{ $itemVal['product_sku'] }}</td>
                    <td style="padding-left: 10px">{{ $itemVal['item_name'] }}</td>
                    @if (isset($itemVal['product_type']))
                        <td style="text-align: center;">{{ $itemVal['product_type'] }}</td>
                    @else
                        <td></td>
                    @endif
                    @if (isset($itemVal['product_size']))
                        <td style="text-align: center;">{{ $itemVal['product_size'] }}</td>
                    @else
                        <td></td>
                    @endif
                    @if (isset($itemVal['product_colour']))
                        <td style="text-align: center;">{{ $itemVal['product_colour'] }}</td>
                    @else
                        <td></td>
                    @endif
                    <td style="text-align: center;">{{ $itemVal['item_quantity'] }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @php $i++; @endphp
            @endforeach
        </tbody>
    </table>

    <br><br>
    <b style="color: #c1d946;">Delievery Instruction</b><br>
    Please do <strong><u>NOT</u></strong> include invoice in the parcel<br><br>

    @if ($order_comment != '' && 1 == 2)
        {{ $order_comment }}<br><br>
    @endif
    <b style="color: #c1d946;">Bettercaremarket Details</b><br>

    Contact Person : Annemarie ter Heide<br>
    Email : supplier@bettercaremarket.com.au<br>
    Phone : 1300 172 151<br>
    Send invoice to Bettercare4U Pty Ltd: accounts@bettercaremarket.com.au; cc supplier@bettercaremarket.com.au<br>
    <strong>Please fill dispatch date and tracking code above</strong><br>
    and return the email to: supplier@bettercaremarket.com.au
    <br>
    Please call me if you have any questions on 1300 172 151.<br>
    <br>

    Kind regards,
    <br>
    <p><strong>Annemarie</strong>, Customer Care Manager</p>
    <img src="{{ asset('assets/images/logo.png') }}" width="100px" height="47px" /><br>
    1300 172 151<br>
    Bettercare4U Pty Ltd, 63 Christie St, St Leonards, NSW 2065<br>
    Mail to : PO Box 422, St Leonards, NSW 1590, Australia<br>
    Email : <a href="mailto:info@bettercaremarket.com.au"><u> info@bettercaremarket.com.au</u> </a><br>
    Web : <a href="https://www.bettercaremarket.com.au/"><u> www.bettercaremarket.com.au</u> </a><br>

</body>

</html>
