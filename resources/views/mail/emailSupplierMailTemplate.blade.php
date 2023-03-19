@component('mail::message')
    # Hey {{ $supplier_name }},

    {{ $data['body'] }}


    Warm regards, <br>
    {{ config('app.signature') }}
@endcomponent
