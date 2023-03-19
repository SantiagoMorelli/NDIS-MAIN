@php
$orderStatus = explode('.', $orderStatus);
$OrderType = $type . '_order';

@endphp
<div>
    <!-- Act only according to that maxim whereby you can, at the same time, will that it should become a universal law. - Immanuel Kant -->
    {{-- {{ Type of orders }} --}}
    <li id={{ $type }} class="rounded-sm relative px-3 py-1 hover:bg-gray-100">
        <button id={{ $OrderType }} class="w-full text-left flex items-center outline-none focus:outline-none">
            <span class="pr-1 flex-1">{{ $type }}</span>
            <span class="mr-auto">
                <svg class="fill-current h-4 w-4
          transition duration-150 ease-in-out"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                </svg>
            </span>
        </button>
        <ul
            class="bg-white border rounded-sm absolute top-0 right-0 transition duration-150 ease-in-out origin-top-left
        w-96 grid grid-cols-3 gap-1">
            @foreach ($orderStatus as $key => $status)
                <button class=" text-left items-center hover:bg-gray-100 m-1">
                    <li id={{ $type . '_status_' . $key }} class={{ 'status_' . $key }}>{{ $status }}</li>
                </button>
            @endforeach

        </ul>
    </li>
</div>
