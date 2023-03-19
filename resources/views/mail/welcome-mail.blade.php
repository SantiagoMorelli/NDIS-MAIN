@component('mail::message')
# Dear {{ $order->customer_first_name . ' ' . $order->customer_last_name }}

This is BetterCareMarket Team.
{{ $message }}



@component('mail::button', ['url' => $link])
link to product
@endcomponent

Thank you! Have a lovely day,<br>
{{ config('app.signature') }}

@endcomponent
