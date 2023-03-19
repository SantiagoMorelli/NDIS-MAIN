@component('mail::message')
# Hi Team,

Can you please send us the tracking number for

<br>
Customer Name : {{ $data['custemer_name'] }} <br>

Our order reference number is : {{ $data['orderNumber'] }}




so we can update them on their order? <br>
Thank you.

<br>
Kind Regards,<br>
{{ config('app.signature') }}
@endcomponent
