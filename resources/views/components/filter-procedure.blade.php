@php
// $orderStatus = [
//     'status_0' => 'Error',
//     'status_1' => 'Pending',
//     'status_2' => 'paid',
//     'status_3' => 'Processed By BCM',
//     'status_4' => 'Pending by Supplier',
//     'status_5' => 'Processed by Supplier',
//     'status_6' => 'Tracking Code Received',
// ];

// $orderStatus = implode('.', $orderStatus);
$orderStatus = implode('.', config('ndis.newOrderStatus'));
@endphp

<div id='filterProcedure' {{ $attributes->merge(['class' => 'group inline-block']) }}">
    <button class="outline-none focus:outline-none border px-3 py-1 bg-white rounded-sm flex items-center w-fit">
        <span class="pr-1 font-semibold flex-1">Filter all orders by</span>
        <span>
            <svg class="fill-current h-4 w-4 transform group-hover:-rotate-180
                   transition duration-150 ease-in-out"
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
            </svg>
        </span>
    </button>
    <ul
        class="bg-white border rounded-sm transform scale-0 group-hover:scale-100 absolute 
               transition duration-150 ease-in-out origin-top min-w-32">

        <li class="rounded-sm relative px-3 py-1 hover:bg-gray-100">
            <button id='ndis_order' class="w-full text-left flex items-center outline-none focus:outline-none">
                <span class="pr-1 flex-1">NDIS</span>
                <span class="mr-auto">
                    <svg class="fill-current h-4 w-4
                       transition duration-150 ease-in-out"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                </span>
            </button>
            <ul id='ndis_procedure'
                class="bg-white border rounded-sm absolute top-0 right-0 
                        transition duration-150 ease-in-out origin-top-left
                     min-w-32">
                {{-- NDIA -- Managed --}}




                {{-- NDIA-managed --}}
                <x-menu :orderStatus='$orderStatus' type='ndia' />
                {{-- plan_managed --}}
                <x-menu :orderStatus='$orderStatus' type='plan_managed' />
                {{-- self_managed --}}
                <x-menu :orderStatus='$orderStatus' type='self_managed' />


            </ul>
        </li>

        {{-- // For none ndis --}}
        <li class="rounded-sm relative px-3 py-1 hover:bg-gray-100">
            <button class="w-full text-left flex items-center outline-none focus:outline-none">
                <span id='non-ndis_order' class="pr-1 flex-1">Non-ndis</span>
                <span class="mr-auto">
                    <svg class="fill-current h-4 w-4
                         transition duration-150 ease-in-out"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                </span>
            </button>
            <ul id='non_ndis_procedure'
                class="bg-white border rounded-sm absolute top-0 right-0 
                      transition duration-150 ease-in-out origin-top-left
                        min-w-32">
                {{-- payPal --}}
                <x-menu :orderStatus='$orderStatus' type='PayPal' />
                {{-- Eway --}}
                <x-menu :orderStatus='$orderStatus' type='Eway' />
                {{-- Afterpay --}}
                <x-menu :orderStatus='$orderStatus' type='Afterpay' />
                {{-- Admin --}}
                <x-menu :orderStatus='$orderStatus' type='Admin' />

            </ul>
        </li>
    </ul>
</div>
