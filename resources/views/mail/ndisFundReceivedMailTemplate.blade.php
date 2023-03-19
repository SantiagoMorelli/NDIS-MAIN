@component('mail::message')
# Good day {{ $customer_full_name }},

We have been informed that the payment for order {{ $orderNumber }} has been made.

We will process the order and keep you updated on tracking details of our suppliers.


If there is anything we can do for you, please let us know.
<br>



Best regards,

{{ config('app.signature') }}
@endcomponent
