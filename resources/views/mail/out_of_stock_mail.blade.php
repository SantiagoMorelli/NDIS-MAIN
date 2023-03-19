@component('mail::message')
# Hey {{ $order->customer_first_name }},

Your recent order of the {{ $product }} is currently out of stock. Our supplier is expecting the item to be back in
stock by {{ $dispatchDate }}.

They’re doing everything they can to send it out as soon as possible once the shipment arrives in their warehouse.

We thank you for your patience!

Best regards,


{{ config('app.signature') }}
@endcomponent
