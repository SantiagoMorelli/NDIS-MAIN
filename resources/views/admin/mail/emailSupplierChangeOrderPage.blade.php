@extends('admin.layouts.app')
@section('title', 'Send email to supplier')
@section('content')

    <!-- .page -->
    <div class="page has-sidebar has-sidebar-expand-xl">
        <!-- .page-inner -->
        <div class="page-inner">
            <!-- .page-title-bar -->
            <div class="fixed flex justify-end bg-red-50 top-2 left-2/4 " style="z-index: 9999;">
                <button class="btn btn-primary border-0 rounded-0 "><span class="text-base">Order
                        : {{ $orderData[0]['order_number'] }} </span></button>

            </div>
            <header class="page-title-bar">
                <h1 class="page-title"> Send email to supplier</h1>

                <div id='updateResult' class="fixed top-16 " style="z-index: 1000000;">
                    <x-authenticate-result />
                </div>
            </header><!-- /.page-title-bar -->
            <!-- .page-section -->
            <div class="page-section w-full">
                <div class="d-xl-none">
                    <button class="btn btn-danger btn-floated" type="button" data-toggle="sidebar"><i
                            class="fa fa-th-list"></i></button>
                </div>

                <!-- .card -->
                <div class="card w-full">
                    <!-- .card-body -->
                    <div class="card-body ">
                        <!-- succes - error messages -->
                        {{-- <x-authenticate-result /> --}}

                        <!-- /succes - error messages -->

                        <!-- form .needs-validation -->
                        <form action="{{ route('emailSupplierChangeOrder', ['supplier_id' => $supplier_id]) }}"
                            method="POST">
                            @csrf

                            <h5 class="pb-3"> Hi team,</h5>

                            <div class="leading-7 text-base form-group">

                                <p> Can we please order the following :</p>

                                <div id="oneSupplierOrderData" class="card-body border-top">
                                    <h5>Customer Details</h5> <br>
                                    <label> First Name : </label>
                                    <input type="text" placeholder="enter first name" class="h-6 rounded mx-1 w-48"
                                        name="customer_first_name" value="{{ $orderData[0]['customer_first_name'] }}"
                                        required>
                                    <br>

                                    <label> Last Name :</label>
                                    <input type="text" placeholder="enter last name" class="h-6 rounded mx-1 w-48"
                                        name="customer_last_name" value=" {{ $orderData[0]['customer_last_name'] }}"
                                        required>
                                    <br>
                                    <label> Phone Number :</label>
                                    <input type="text" placeholder="enter phone number" class="h-6 rounded mx-1 w-48"
                                        name="customer_phone_number" value="  {{ $orderData[0]['customer_phone_number'] }}"
                                        required>
                                    <br>
                                    <label>Shipping Adress : </label><br>
                                    <label><input type="text" placeholder="enter shipping address street"
                                            class="h-6 rounded mx-1 w-48" name="shipping_address_street"
                                            value="  {{ $orderData[0]['shipping_address_street'] }}" required></label><br>
                                    <label><input type="text" placeholder="enter shipping address city"
                                            class="h-6 rounded mx-1 w-48" name="shipping_address_city"
                                            value="  {{ $orderData[0]['shipping_address_city'] }}" required></label> ,
                                    <label><input type="text" placeholder="enter shipping address state"
                                            class="h-6 rounded mx-1 w-48" name="shipping_address_state"
                                            value="  {{ $orderData[0]['shipping_address_state'] }}" required></label><br>
                                    <label><input type="text" placeholder="enter pin code" class="h-6 rounded mx-1 w-48"
                                            name="shipping_address_post_code"
                                            value="  {{ $orderData[0]['shipping_address_post_code'] }}" required></label>
                                    <br>
                                    <label>Order Date :<input type="text" placeholder="enter phone number"
                                            class="h-6 rounded mx-1 w-48" name="order_date"
                                            value="  {{ $orderData[0]['order_date'] }}" required></label><br><br>

                                    <h5>Order Item details</h5>
                                    <div style="overflow-x:auto;">
                                        <table id="orderData" class="table dt-responsive nowrap w-100 mt-2 border-2">
                                            <thead>
                                                <tr>
                                                    <th> Order No. </th>
                                                    <th> Product Name </th>
                                                    <th> Quantity </th>
                                                    <th> Product Sku</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($orderData as $data)
                                                    <tr>
                                                        <td> <input type="text" class="h-6 rounded mx-1 w-36"
                                                                name="order_number" value=" {{ $data['order_number'] }}"
                                                                required readonly> </td>
                                                        <td><input type="text" placeholder="enter item name"
                                                                class="h-6 rounded mx-1 w-48" name="item[]"
                                                                value="{{ $data['item_name'] }}" required readonly> </td>
                                                        <td><input type="text" placeholder="enter quantity"
                                                                class="h-6 rounded mx-1 w-36" name="item[]"
                                                                value=" {{ $data['item_quantity'] }}" required readonly>
                                                        </td>
                                                        <td><input type="text" placeholder="enter product sku"
                                                                class="h-6 rounded mx-1 w-48" name="item[]"
                                                                value="{{ $data['product_sku'] }}" required readonly> </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>

                                        </table>
                                    </div>
                                    <br>
                                    <h5>Please enter details for updated order</h5> <br>
                                    <div>
                                        <textarea class="h-6 rounded mx-1 w-36" placeholder="enter description" name="description"
                                            style="width:300px;height:50px; position: absolute;  display: inline-block;" required></textarea>
                                    </div><br>
                                    @if (isset($orderData[0]['order_comment']))
                                        <label>Order Note : <input type="text" placeholder="enter phone number"
                                                class="h-6 rounded mx-1 w-48" name="product_sku"
                                                value=" {{ $orderData[0]['order_comment'] }}" required> </label>
                                    @endif
                                    <br>

                                </div>

                                <p> If you can please send us the tracking information for this order, that would be greatly
                                    appreciated. </p>
                                <br>
                                Warm regards,
                                <br>
                                {{ config('app.signature') }}

                            </div>

                            <!-- .form-actions -->
                            <div class="form-actions">
                                <a href="{{ route('viewOrderDetails', ['id' => $orderData[0]['order_number']]) }}">
                                    <button class="btn btn-secondary shadow-sm btn--sm mr-2" type="button">Cancel</button>
                                </a>
                                <button class="btn btn-primary" type="submit">Send</button>
                            </div><!-- /.form-actions -->
                        </form><!-- /form .needs-validation -->
                    </div><!-- /.card-body -->
                </div><!-- /.card -->

            </div><!-- /.page-section -->
        </div><!-- /.page-inner -->
    </div><!-- /.page -->
@endsection

@push('scripts')
    <script type="text/javascript">
        $('#getOneOrderData').on('submit', function(e) {
            e.preventDefault();
            var orderNumber = $('#orderNumber').val();
            var supplier_id = $('#supplier_id').val();
            var url = "{{ route('getOneSupplierOrderData', 'orderNumber') }}";
            var url = url.replace('orderNumber', orderNumber);

            $.ajax({
                type: "GET",
                url: url,
                data: {
                    orderNumber,
                    supplier_id
                },

                success: function(res) {
                    res = JSON.parse(res);
                    if (res.status == 1) {

                        var html = res.html;
                        $('#oneSupplierOrderData').append(
                            html
                        );
                    } else {
                        $("#updateResult").append(
                            '<div class="alert alert-danger" role="alert"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>   Order number is not valid for this supplier     </div>'
                        );
                    }

                },
                error: function(res) {

                    $("#updateResult").append(
                        '<div class="alert alert-danger" role="alert"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>  Order number is not valid       </div>'
                    );

                }

            });

        });
    </script>
@endpush
