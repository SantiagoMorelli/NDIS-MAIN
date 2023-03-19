@php
    $orderStatus = config('ndis.newOrderStatus');
    $orderStatus = array_values($orderStatus);
    
@endphp
{{-- flex flex-wrap justify-evenly mt-4 --}}
{{-- class='grid grid-cols-3 mt-4' --}}
<div id='filterCriteria' class='grid grid-cols-3 mt-4'>
    <div class="form-group flex content-center text-base">
        <label for="start_date" class='inline-block pt-1.5 pr-2'>From</label>
        <input type="date" name="start_date" id="start_date"
            class=" datepicker-autoclose w-40 h-9 border-gray-300 rounded shadow-sm">
    </div>
    <div class='form-group flex content-center text-base'>

        <label for="end_date" class='inline-block pt-1.5 pr-3'>To</label>

        <input type="date" name="end_date" id="end_date"
            class="datepicker-autoclose w-40 h-9 border-gray-300 rounded shadow-sm">
    </div>

    <div class='form-group flex content-center text-base'>
        <label for="shipping_address" class='inline-block pt-1.5 pr-2'>Address</label>
        <input type="text" name="shipping_address" id="shipping_address"
            class=" w-40 h-9 border-gray-300 rounded shadow-sm">
    </div>
    <div class="form-group ">
        <label for="order_status" class='text-base'>Status</label>
        <select id="order_status" name="order_status" class='border-gray-300 rounded shadow-sm w-40'>
            <option value="">Please select</option>
            {{-- <option value="0">Error</option>
            <option value="1">Pending</option>
            <option value="2">Paid</option>
            <option value="3">Processed by BCM</option>
            <option value="4">Pending by Supplier</option>
            <option value="5">Processed by Supplier</option>
            <option value="6">Tracking Code Received</option> --}}
            @foreach ($orderStatus as $key => $value)
                <option value={{ $key }}>{{ $value }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group ">
        <label for="order_status_secondary" class='text-base'>Sub</label>
        <select id="order_status_secondary" name="order_status_secondary"
            class='border-gray-300 rounded shadow-sm w-40'>
            <option value="">Please select</option>
            <option value="3">not Processed by BCM</option>
            <option value="4">not Pending by Supplier</option>
            <option value="5">not Processed by Supplier</option>
            <option value="6">no Tracking Code Received</option>
            <option value="7">not delivered</option>
        </select>
    </div>
    <div class="form-group">
        <label for="payment" class='text-base'>Payment</label>
        <select id="payment" name="payment" class='border-gray-300 rounded shadow-sm w-40'>
            <option value="">Please select</option>
            <option value="afterpay">afterpay</option>
            <option value="paypal">paypal</option>
            <option value="eway">eway</option>
            <option value="admin">Admin</option>
        </select>

    </div>
    <div class="form-group">
        <label for="category" class='text-base'>Type</label>
        <select id="category" name="category" class='border-gray-300 rounded shadow-sm w-40 '>
            <option value="">Please select</option>
            <option value="ndis">ndis</option>
            <option value="non-ndis">non-ndis</option>
        </select>
        {{-- <input type="text" class="form-control" name="order_status" id="order_status" placeholder="order_status"> --}}
    </div>

    <div class="form-group">
        <label for="ndis_type_select" class='text-base'>NDIS</label>
        <select id="ndis_type_select" name="ndis_type_select" class='border-gray-300 rounded shadow-sm w-40'>
            <option value="">Please select</option>
            <option value="NDIA-managed">NDIA-managed</option>
            <option value="Plan-managed">Plan-managed</option>
            <option value="Self-managed">Self-managed</option>
        </select>
    </div>

    <div class='form-group flex content-center text-base'>
        <label for="supplier_invoice" class='inline-block pt-1.5 pr-2'>Supplier Invoice</label>
        <input type="text" name="supplier_invoice" id="supplier_invoice" placeholder="Enter supplier invoice number"
            class=" w-40 h-9 border-gray-300 rounded shadow-sm">
    </div>

    {{-- <input type="text" class="form-control" name="order_status" id="order_status" placeholder="order_status"> --}}
</div>
