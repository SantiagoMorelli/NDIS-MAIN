@component('mail::message')
# Hi Team,

Can we please check the ETAs for the following products - whether they have come in, or if the dates have been pushed
back?
<br>

@php $i=0 @endphp
@foreach ($valid_sku as $sku)
Product {{ $i + 1 }} SKU - {{ $sku }} <br>
@php $i++ @endphp
@endforeach

<br>

If you can get back to us on this, that would be greatly appreciated.

Kind Reagrds,<br>
{{ config('app.signature') }}
@endcomponent
