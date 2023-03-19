<tr>
    <td class="header" id='testHeader'>
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
                {{-- <img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">? --}}
                <img src=asset('assets/images/logo/bettercare.svg') class="logo" alt="Bettercare Logo">
            @else
                {{-- {{ $slot }} --}}
                <img src="{{ asset('assets/images/logo/bettercare.svg') }}" class="logo_mini"
                    alt="Bettercare Logo">
                <div class="inline-block">
                    <span class="header_green">better</span><span class="header_blue">care</span><span
                        class="header_green">market</span>

                </div>
            @endif
        </a>
    </td>
</tr>
