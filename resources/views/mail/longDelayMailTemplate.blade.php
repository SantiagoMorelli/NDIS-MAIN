@component('mail::message')
# Hey {{ $order->customer_first_name }},

Unfortunately, we just been informed by our supplier that

@foreach ($product as $item)
{{ $item }} <br>
@endforeach
<br>
is out of stock until

{{ $data['date'] }}.

Please let us know if you are happy to wait and we will let you know of any changes.

If you would prefer a refund for this item, feel free to contact us.

We thank you for your patience!

Best regards,

{{ config('app.signature') }}
@endcomponent
