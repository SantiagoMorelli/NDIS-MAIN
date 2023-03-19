@component('mail::message')
# Hi Team

Can you please do changes for the following order:

Order Number : {{ $data['order_number'] }}

Order Details:

@component('mail::table')
| Item Name | Quantity | Product Sku |
| :------------- | :------------- | :------------- |
@foreach ($item as $array)
| {{ $array[0] }} | {{ $array[1] }} | {{ $array[2] }} |
@endforeach
@endcomponent

<br>

Changing Details:

{{ $data['description'] }}



# For the following customer:

{{ $fullname }}<br>

{{ ucfirst($data['shipping_address_street']) }} <br>
{{ ucfirst($data['shipping_address_city']) }} <br>
{{ ucfirst($data['shipping_address_state']) }}, {{ $data['shipping_address_post_code'] }} <br>

Customer contact no: {{ $data['customer_phone_number'] }}

@if (isset($data['order_comment']))
Please include the following delivery instructions for this order: “X INSTRUCTIONS HERE X.”
{{ ucfirst($data['order_comment']) }}
@endif



If you can please send us the tracking information for this order, that would be greatly appreciated.

Kind Regards, <br>
{{ config('app.signature') }}
@endcomponent
