@component('mail::message')
# Hey {{ $order->customer_first_name }},

We are pleased to inform you that the following product(s) are currently being prepared for dispatch:



@component('mail::table')
| Product | Tracking number |
| :--------- | :------------- |
@foreach ($tracking as $array)
| {{ $array[0] }} | @if ($array[2] != 'N/A')
<a href="{{ $array[2] }}"> {{ $array[1] }} </a>
@else
{{ $array[1] }}
@endif |
@endforeach
@endcomponent


Click on the tracking number to check the progress.

Please don't hesitate to contact us if you have any queries, or if you would like a further update.

Thank you for shopping with us!


Warm regards,

{{ config('app.signature') }}
@endcomponent
