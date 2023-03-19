@component('mail::message')
# Hi Team

Can you please update us on the status of

<br>

Order No : {{ $data['orderNumber'] }}


<br> whether this has been dispatched?
<br>

The customer is following up on this order, and we’d love to give them some more information on its progress.



Kind Reagrds, <br>

{{ config('app.signature') }}
@endcomponent
