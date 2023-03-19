<?php
use App\Repositories\CommonRepository;
$planManaged = false;
?>
@extends('admin.layouts.app')
@section('title', 'Order Details')
@section('content')
    <!-- .page -->

    <div class="page has-sidebar has-sidebar-expand-xl">
        <!-- .page-inner -->
        <div class="page-inner" style="margin-right: 0 !important">
            <!-- .page-title-bar -->
            <div class="fixed flex justify-end bg-red-50 top-2 left-2/4 " style="z-index: 9999;">
                <button class="btn btn-primary border-0 rounded-0 "><span class="text-base">Order
                        : {{ $orderId }} </span> | <span class="text-base">Date
                        : {{ date('Y-m-d', strtotime($order->order_date)) }} </span></button>
                @if ($finish)
                    <button class="btn btn-primary border-0 rounded-0 " onclick="finishWorkingOrder()"><span
                            class="text-base">finish</span></button>
                @endif
            </div>
            <header class="page-title-bar">
                <!-- .breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">

                            <a href="{{ url()->previous() }}">

                                <i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Back</a>
                        </li>
                    </ol>
                </nav><!-- /.breadcrumb -->
                <div class='flex justify-between'>
                    <h1 class="page-title"> View Order </h1>

                    {{-- <x-forms.modal />
                    <div class="relative inset-x-2/4 " style="top:2rem;">
                        <x-create-ticket-modal :orderId="$orderId" />
                    </div> --}}

                </div>


                <div id='updateResult' class="fixed top-16 " style="z-index: 1000000;">
                    <x-authenticate-result />
                </div>




            </header><!-- /.page-title-bar -->
            <!-- .page-section -->
            <div class="page-section">
                <div class="d-xl-none">
                    <button class="btn btn-danger btn-floated" type="button" data-toggle="sidebar"><i
                            class="fa fa-th-list"></i></button>
                </div>
                <!-- .card -->
                <div class="card">
                    <!-- .card-body -->
                    <div class="card-body">
                        <!-- .form-row -->
                        <legend>
                            <div class="flex justify-start">
                                <h5 class="mr-4">Customer Details</h5>
                                {{-- <x-email-customer /> --}}

                            </div>
                        </legend>
                        <div id='loading_spinner' style="z-index: 10000"
                            class="spinner-border text-danger d-none inset-1/2 fixed " role="status">
                            <span class="sr-only ">Loading...</span>
                        </div>
                        {{-- <button id="emailCustomer" type="button" class="btn btn-info">contact customer</button> --}}
                        <div class="hidden">
                            <input type="text" id='id_ticket' value={{ $orderId }}>
                        </div>
                        <div class="hidden">
                            <input type="text" id='orderNum' value={{ $orderId }}>
                        </div>

                        <div class="form-group">
                            <!-- form grid -->
                            <div class="col-md-12">
                                <label for="validationTooltipUsername"><b>First Name : </b></label>
                                {{ $order->customer_first_name }}
                            </div><!-- /form grid -->

                            <!-- form grid -->
                            <div class="col-md-12">
                                <label for="validationTooltipUsername"><b>Last Name : </b></label>
                                {{ $order->customer_last_name }}
                            </div><!-- /form grid -->

                            <!-- form grid -->
                            <div class="col-md-12">
                                <label for="validationTooltipUsername"><b>Email : </b></label>
                                {{ $order->customer_email }}
                            </div><!-- /form grid -->

                            <!-- form grid -->
                            <div class="col-md-12">
                                <label for="validationTooltipEmail"><b>Contact Phone Number :</b> </label>
                                {{ $order->customer_phone_number }}
                            </div><!-- /form grid -->

                            <!-- form grid -->
                            <div class="col-md-12">
                                <label for="validationTooltipEmail"><b>Billing Address : </b></label>
                                {{ $order->billing_address_company }}@if ($order->billing_address_company)
                                    ,
                                    @endif {{ $order->billing_address_street }}@if ($order->billing_address_street)
                                        ,
                                        @endif{{ $order->billing_address_city }}@if ($order->billing_address_city)
                                            ,
                                            @endif{{ $order->billing_address_state }}@if ($order->billing_address_state)
                                                ,
                                            @endif{{ $order->billing_address_post_code }}
                            </div><!-- /form grid -->

                        </div><!-- /.form-row -->
                    </div><!-- /.card-body -->

                    <div class="card-body">
                        <!-- .form-row -->
                        <legend>
                            <div class="flex justify-start">
                                <h5 class="mr-4">End User Details</h5>
                            </div>
                        </legend>
                        <div class="form-group">
                            <!-- form grid -->
                            <div class="col-md-12">
                                <label for="validationTooltipUsername"><b>First Name : </b></label>
                                {{ $order->shipping_address_first_name }}
                            </div><!-- /form grid -->

                            <!-- form grid -->
                            <div class="col-md-12">
                                <label for="validationTooltipUsername"><b>Last Name : </b></label>
                                {{ $order->shipping_address_last_name }}
                            </div><!-- /form grid -->

                            <!-- form grid -->
                            <div class="col-md-12">
                                <label for="validationTooltipUsername"><b>Email : </b></label>
                                {{ $order->invoice_email_address }}
                            </div><!-- /form grid -->

                            <!-- form grid -->
                            <div class="col-md-12">
                                <label for="validationTooltipEmail"><b>Contact Phone Number :</b> </label>
                                {{ $order->contact_phone_number }}
                            </div><!-- /form grid -->

                            <!-- form grid -->
                            <div class="col-md-12">
                                <label for="validationTooltipEmail"><b>Shipping Address : </b></label>
                                {{ $order->shipping_address_company }}@if ($order->shipping_address_company)
                                    ,
                                    @endif {{ $order->shipping_address_street }}@if ($order->shipping_address_street)
                                        ,
                                        @endif{{ $order->shipping_address_city }}@if ($order->shipping_address_city)
                                            ,
                                            @endif{{ $order->shipping_address_state }}@if ($order->shipping_address_state)
                                                ,
                                            @endif{{ $order->shipping_address_post_code }}
                            </div><!-- /form grid -->
                        </div><!-- /.form-row -->
                    </div><!-- /.card-body -->




                    <!-- .card-body -->
                    <div class="card-body border-top">
                        <!-- .form-row -->
                        <legend>
                            <h5>Order Details</h5>
                        </legend>
                        <div class="form-group">
                            <!-- form grid -->
                            <div class="col-md-12">
                                <label><b>SubTotal : </b></label>
                                {{ floatval($order->order_total) - ($order->gst_total ? floatval($order->gst_total) : 0) - ($order->shipping_total ? floatval($order->shipping_total) : 0) }}
                            </div><!-- /form grid -->
                            <!-- form grid -->
                            <div class="col-md-12">
                                <label><b>Shipping Total :</b> </label> {{ $order->shipping_total }}
                            </div><!-- /form grid -->
                            <!-- form grid -->
                            <div class="col-md-12">
                                <label><b>Gst Total : </b></label> {{ $order->gst_total }}
                            </div><!-- /form grid -->
                            <!-- form grid -->
                            <div class="col-md-12">
                                <label><b>Grand Total(Excl. Tax) : </b></label>
                                {{ floatval($order->order_total) - ($order->gst_total ? floatval($order->gst_total) : 0) }}
                            </div><!-- /form grid -->
                            <!-- form grid -->
                            <div class="col-md-12">
                                <label><b>Grand Total(Incl. Tax) : </b></label> {{ $order->order_total }}
                            </div><!-- /form grid -->
                        </div><!-- /.form-row -->
                    </div><!-- /.card-body -->

                    <!-- .card-body -->
                    <div class="card-body border-top">
                        <legend>
                            <div class="flex justify-between">
                                <h5>Tickets</h5>
                                {{-- <x-create-ticket-modal :orderId="$orderId" /> --}}
                                <x-create-ticket-modal :orderNum="$orderId" />
                            </div>
                        </legend>
                        <table id="ticket_datatable" class="table dt-responsive nowrap w-100 mt-2 border-2">
                            <thead>
                                <tr>
                                    <th> Subject </th>
                                    <th> Status </th>
                                    {{-- <th> OrderId </th> --}}
                                    <th> Due Date </th>
                                    {{-- <th> Create Time </th> --}}
                                    <th> Notes</th>
                                    <th> Action </th>
                                </tr>
                            </thead>
                        </table><!-- /.table -->
                    </div><!-- /.card-body -->

                    <!-- .card-body -->
                    <div class="card-body border-top">
                        <legend>
                            <div class="flex justify-between">
                                <h5>Order Items</h5>
                                <div>
                                    <p class="font-normal">out of stock? nofity customer
                                        <a href="javascript:void(0);"
                                            data-url="{{ route('outOfStockPage', ['orderNumber' => $orderId, 'sku' => ($sku = null)]) }}"
                                            id="shortdelay" onclick="getItemDataShortDelay(this)">
                                            <button class="btn btn-secondary mr-4"> short
                                                delay</button></a>
                                        <a href="javascript:void(0);"
                                            data-url="{{ route('longDelayPage', ['orderNumber' => $orderId, 'sku' => ($sku = null)]) }}"
                                            id="longdelay" onclick="getItemDataLongDelay(this)">
                                            <button class="btn btn-secondary mr-4"> Long delay</button></a>
                                    <div id="trackingModal">
                                        <x-backdrop-modal :orderId="$orderId" />
                                    </div>
                                    </p>
                                </div>
                            </div>
                        </legend>
                        <!-- .table -->
                        <table id="itemlist-datatable" class="table dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th> </th>
                                    <th> Item Name </th>
                                    <th> sku </th>
                                    <th> Size </th>
                                    <th> Colour </th>
                                    <th> Quantity </th>
                                    <th> Price </th>
                                    <th> supplier id </th>
                                    <th> Supplier Order Date </th>
                                </tr>
                            </thead>
                        </table><!-- /.table -->
                    </div><!-- /.card-body -->

                    <!-- .card-body -->
                    <div class="card-body border-top">
                        <legend>
                            <div class="flex justify-between">
                                <h5>Tracking information</h5>
                                <a href="" onclick="getTrackingInfo()" id="trackinginfo"
                                    data-url="{{ route('sendTrackingEmailPage', ['orderNumber' => $orderId, 'tracking_id' => ($tracking_id = null)]) }}">
                                    <button class="btn btn-success"> send tracking email</button>
                                </a>
                            </div>
                            {{-- <x-backdrop-modal :orderId="$orderId" /> --}}
                        </legend>
                        <!-- .table -->
                        <table id="shipping-datatable" class="table dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    {{-- <th> </th> --}}
                                    <th> Item Name </th>
                                    <th> Tracking id </th>
                                    <th> Courier Company </th>
                                    <th> Expected Arrival Time : </th>
                                    <th> Dispatch Time </th>
                                    <th> Notes </th>
                                    <th> Action </th>
                                </tr>
                            </thead>
                        </table><!-- /.table -->


                    </div><!-- /.card-body -->


                    <!-- .card-body -->
                    <div class="card-body border-top">
                        <legend>

                            <div class="flex justify-between">
                                <h5>Supplier</h5>
                            </div>
                        </legend>
                        <table id="supplier_datatable" class="table dt-responsive nowrap w-100 mt-2">
                            <thead>
                                <tr>
                                    <th> Supplier_id </th>
                                    <th> Supplier Name </th>
                                    <th> supplier email</th>
                                    {{-- <th> product sku </th> --}}
                                    <th> Invoice Number </th>
                                    <th> Action </th>
                                </tr>
                            </thead>
                        </table><!-- /.table -->
                    </div><!-- /.card-body -->


                    <!-- .card-body -->
                    <div class="card-body border-top">
                        <legend>
                            <div class="flex justify-between">
                                <h5>Comments</h5>
                                <x-forms.modal />
                            </div>

                        </legend>
                        <!-- .table -->
                        <table id="comment_datatable" class="table dt-responsive nowrap w-100">
                            <thead>
                                <tr>

                                    <th> comment </th>
                                    <th> created At </th>

                                </tr>
                            </thead>
                        </table><!-- /.table -->
                    </div><!-- /.card-body -->


                    <!-- .card-body -->
                    <div class="card-body border-top">
                        <legend>
                            <div class="flex justify-between">
                                <h5>Emails</h5>
                            </div>
                        </legend>
                        <!-- .table -->
                        <table id="emaillog_datatable" class="table dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th> Subject </th>
                                    <th> To </th>
                                    <th> From </th>
                                    <th> Cc </th>
                                    <th> Bcc </th>
                                    <th> Email Sent Date </th>
                                </tr>
                            </thead>
                        </table><!-- /.table -->
                    </div><!-- /.card-body -->

                </div><!-- /.card -->

            </div><!-- /.page-section -->
        </div><!-- /.page-inner -->
    </div><!-- /.page -->
@endsection

@push('styles')
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/javascript/pages/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('assets/javascript/pages/datatables-responsive-demo.js') }}"></script>
    <script type="text/javascript">
        var ticketTable = $('#ticket_datatable').DataTable({
            // pageLength: 10,
            // pageLength: 3,
            info: false,
            // lengthMenu: [
            //     [3, 5, 10, 20],
            //     [3, 5, 10, 20]
            // ],
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: '{{ route('getAllTickets') }}',
                data: function(d) {

                    d.id_ticket = $('#id_ticket').val();
                },
                error: function(xhr, error, code) {
                    $('#ticket_datatable').DataTable().ajax.reload();
                }


            },
            responsive: true,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>\n        <'table-responsive'tr>\n        <'row align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 d-flex justify-content-end'p>>",
            language: {
                paginate: {
                    previous: '<i class="fa fa-lg fa-angle-left"></i>',
                    next: '<i class="fa fa-lg fa-angle-right"></i>'
                }
            },
            columns: [{
                    data: 'subject'
                },
                {
                    data: 'status',
                    render: function(data, type, row) {

                        if (data == 'closed') {
                            return '<div class="bg-success badge text-white"> closed </div>';
                        } else if (data == 'open') {
                            return '<div class="bg-danger badge text-white"> open </div>';
                        } else if (data == 'processing') {
                            return "<div class='bg-warning badge text-white'> processing </div>";
                        } else {
                            return 'error';
                        }

                    }
                },

                {
                    data: 'due_date'
                },

                {
                    data: 'notes'
                },
                {
                    data: 'action',
                    orderable: false
                },
            ]
        });

        function getTrackingInfo() {

            var checkedBoxes = $("input.trackingcheckbox:checked").map(function() {
                return $(this).val();
            }).get();
            if (checkedBoxes == '') {
                $('#trackinginfo').attr("href", '#')
                alert('Please select atleast one row from Tracking Information ');
                return false;
            } else {
                var tracking_number = $("input.trackingcheckbox:checked").attr('data');
                var item_name = $("input.trackingcheckbox:checked").attr('data-itemname');
                val = $('#trackinginfo').attr('data-url') + '/' + checkedBoxes;
                //alert(val);
                $('#trackinginfo').attr("href", val)
            }
        }
        var shippingTable = $('#shipping-datatable').DataTable({

            processing: true,
            serverSide: true,
            //searching: false,
            // ajax: "{{ route('getOrderSupplier', ['orderNumber' => $orderId]) }}",
            // ajax: "{{ url('admin/order_shipping') }}/{{ $orderId }}",
            ajax: {
                url: "{{ url('admin/order_shipping') }}/{{ $orderId }}",
                type: "GET",
                error: function(xhr, error, code) {
                    $('#shipping-datatable').DataTable().ajax.reload();
                }

            },
            responsive: true,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>\n <'table-responsive'tr>\n <'row align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 d-flex justify-content-end'p>>",
            language: {
                paginate: {
                    previous: '<i class="fa fa-lg fa-angle-left"></i>',
                    next: '<i class="fa fa-lg fa-angle-right"></i>'
                }
            },
            columns: [
                // {
                //     data: 'check',
                //     orderable: false
                // },
                {
                    data: 'item_name'
                },
                {
                    data: 'tracking_number'
                },
                {
                    data: 'courier_company'
                },
                {
                    data: 'expected_time_of_arrival'
                },
                {
                    data: 'dispatch_time'
                },
                {
                    data: 'notes'
                },
                {
                    data: 'action',
                    orderable: false
                },
            ],
            order: [
                [0, 'desc']
            ]
        });




        var supplierTable = $('#supplier_datatable').DataTable({
            // info: false,
            processing: true,
            serverSide: true,
            searching: false,
            // ajax: "{{ url('admin/orders') . '/2859' . '/supplier' }}",
            // ajax: "{{ route('getOrderSupplier', ['orderNumber' => $orderId]) }}",

            ajax: {
                url: "{{ route('getOrderSupplier', ['orderNumber' => $orderId]) }}",
                type: "GET",
                error: function(xhr, error, code) {
                    $('#supplier_datatable').DataTable().ajax.reload();
                }
                // success: function(res) {
                //     console.log(res);
                // }

            },
            responsive: true,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>\n        <'table-responsive'tr>\n        <'row align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 d-flex justify-content-end'p>>",
            language: {
                paginate: {
                    previous: '<i class="fa fa-lg fa-angle-left"></i>',
                    next: '<i class="fa fa-lg fa-angle-right"></i>'
                }
            },
            columns: [{
                    data: 'supplier_id'
                },
                {

                    data: 'supplier_name'
                },

                // {
                //     data: 'order_id'
                // },

                {
                    data: 'supplier_emailid',
                    // 'render': function(data, type, row, meta) {
                    //     var supplier_id = row.supplier_id;
                    //     var url = '{{ route('emailSupplierPage', 'id') }}';
                    //     url = url.replace("id", supplier_id);
                    //     return '<a href="' + url + '"  >' + data + '"</a>';
                    // }
                },
                // {
                //     data: 'product_sku'
                // },
                {
                    data: 'invoice_number',
                    'render': function(data, type, row, meta) {
                        var invoice_number = row.invoice_number;
                        var order_id = row.order_id;
                        var recordNumber = row.record_number;
                        if (invoice_number != null) {
                            var url =
                                '{{ route('addSupplierInvoice', 'id') }}';
                            url = url.replace("id", order_id);
                            return '<form method="post" action=" ' + url +
                                '"><input type="hidden" value="' +
                                recordNumber +
                                '" name="record_number" /><input type="text" name="invoice_number" value=" ' +
                                invoice_number +
                                '" class="h-7 rounded w-36" style="color:black;" placeholder="Enter invoice no" />' +
                                '<button type="submit" class="btn btn-primary shadow-sm btn-xs mr-2 py-0" style="margin-left: 5px;">Edit</button></form>';
                        } else {
                            var url =
                                '{{ route('addSupplierInvoice', 'id') }}';
                            url = url.replace("id", order_id);
                            return '<form method="post" action=" ' + url +
                                '"><input type="hidden" value="' +
                                recordNumber +
                                '" name="record_number" /><input type="text" name="invoice_number" value=" ' +
                                invoice_number +
                                '" class="h-7 rounded w-36" style="color:black;" placeholder="Enter invoice no" />' +
                                '<button type="submit" class="btn btn-primary shadow-sm btn-xs mr-2 py-0" style="margin-left: 5px;">Add</button></form>';
                        }

                    }


                },
                {
                    data: 'action',
                    orderable: false

                }
            ]
        });


        var orderItemTable = $('#itemlist-datatable').DataTable({
            processing: true,
            serverSide: true,
            // Info: true,

            ajax: {
                url: "{{ route('getOrderProducts', ['id' => $orderId]) }}",
                type: "GET",
                error: function(xhr, error, code) {
                    $('#itemlist-datatable').DataTable().ajax.reload();
                }

            },
            responsive: true,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>\n <'table-responsive'tr>\n  <'row align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 d-flex justify-content-end'p>>",
            language: {
                paginate: {
                    previous: '<i class="fa fa-lg fa-angle-left"></i>',
                    next: '<i class="fa fa-lg fa-angle-right"></i>'
                }
            },
            columns: [{
                    data: 'check',
                    orderable: false
                },
                {
                    data: 'item_name'
                },
                {
                    data: 'item_sku'
                },
                {
                    data: 'item_size'
                },
                {
                    data: 'item_colour'
                },
                {
                    data: 'item_quantity'
                },
                {
                    data: 'item_price'
                },
                {
                    data: 'supplier_id'
                },
                {
                    data: 'supplier_order_date'
                },

            ],
            order: [
                [0, 'desc']
            ]
        });

        // get values of items by clicking check boxes from item table
        function handleClick(cb) {
            if (cb.checked) {
                var checkedBoxes = $("input.itemcheckbox:checked").map(function() {
                    return $(this).val();
                }).get();
                // alert(checkedBoxes);
            }
        }

        function getItemDataShortDelay() {
            var checkedBoxes = $("input.itemcheckbox:checked").map(function() {
                return $(this).val();
            }).get();
            if (checkedBoxes == '') {
                $('#shortdelay').attr("href", '#')
                alert('Please select atleast one item from Order items');
                return false;
            } else {
                val = $('#shortdelay').attr('data-url') + '/' + checkedBoxes;
                $('#shortdelay').attr("href", val)
            }
        }

        function getItemDataLongDelay() {
            var checkedBoxes = $("input.itemcheckbox:checked").map(function() {
                return $(this).val();
            }).get();
            if (checkedBoxes == '') {
                $('#longdelay').attr("href", '#')
                alert('Please select atleast one item from Order items');

                return false;
            } else {
                val = $('#longdelay').attr('data-url') + '/' + checkedBoxes;
                $('#longdelay').attr("href", val)

            }


        }


        var commentTable = $('#comment_datatable').DataTable({
            searching: false,
            processing: true,
            serverSide: true,
            info: false,


            ajax: {
                url: '{{ route('getCommentsPage') }}',
                data: function(d) {

                    d.orderNumber = $('#orderNum').val();;
                },
                type: "GET",
                error: function(xhr, error, code) {
                    $('#comment_datatable').DataTable().ajax.reload();
                }

            },
            responsive: true,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>\n        <'table-responsive'tr>\n        <'row align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 d-flex justify-content-end'p>>",
            language: {
                paginate: {
                    previous: '<i class="fa fa-lg fa-angle-left"></i>',
                    next: '<i class="fa fa-lg fa-angle-right"></i>'
                }
            },
            columns: [
                // {
                //     data: 'order_number'
                // },
                {
                    data: 'comment'
                },
                {
                    data: 'created_at'
                },

            ],
            order: [
                [1, 'desc']
            ]
        });



        //Email log datatbles
        var emaillogTable = $('#emaillog_datatable').DataTable({
            searching: false,
            processing: true,
            serverSide: true,
            info: false,
            ajax: {
                url: '{{ route('getEmailLogsPage', ['orderNumber' => $orderId]) }}',
                type: "GET",
                error: function(xhr, error, code) {
                    $('#emaillog_datatable').DataTable().ajax.reload();
                }
            },
            responsive: true,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>\n        <'table-responsive'tr>\n        <'row align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 d-flex justify-content-end'p>>",
            language: {
                paginate: {
                    previous: '<i class="fa fa-lg fa-angle-left"></i>',
                    next: '<i class="fa fa-lg fa-angle-right"></i>'
                }
            },
            columns: [{
                    data: 'subject'
                },
                {
                    data: 'to'
                },
                {
                    data: 'from'
                },
                {
                    data: 'cc'
                },
                {
                    data: 'bcc'
                },
                {
                    data: 'emaildate'
                }

            ],
            order: [
                [1, 'desc']
            ]
        });




        //start of control tracking form 

        $('#createTrackingForm').on('submit', function(e) {
            // let item_name = [];
            // let product_sku = [];
            let orderId = $('#orderNum').val();
            let trackingNumber = $('#trackingNumber').val();
            let courierCompany = $('#courierCompany').val();
            let eta = $('#eta').val();
            let dispatchTime = $('#dispatchTime').val();
            let tracking_notes = $('#tracking_notes').val();
            var SupplierId = $('#SupplierId').val();
            var skus = $('input[name="product_sku[]"]').map(function() {
                return this.value;
            }).get();
            var items = $('input[name="itemName[]"]').map(function() {
                return this.value;
            }).get();

            //e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('createTrackingRecord') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    orderId,
                    'product_sku[]': skus,
                    'item_name[]': items,
                    trackingNumber,
                    courierCompany,
                    eta,
                    dispatchTime,
                    tracking_notes,
                    SupplierId,
                },
                dataType: 'json',
                success: function(res) {
                    window.location.reload();
                    $('#modalMain').modal('hide');
                    $("#updateResult").append(
                        '<div class="alert alert-success" role="alert"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>Successfully create a tracking record</div>'
                    );


                },
                error: function(res) {
                    window.location.reload();
                    $("#updateResult").append(
                        '<div class="alert alert-danger" role="alert"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>Failed to create a tracking record</div>'
                    );

                }
            });

            hideNotification();

        });


        $('#modalButton').click(function() {


            var checkedBoxes = $("input.itemcheckbox:checked").map(function() {
                return $(this).val();

            }).get();
            if (checkedBoxes == '') {

                alert('Please select at least one item from Order items');
                return false;

            } else {
                var item_name = $("input.itemcheckbox:checked").map(function() {
                    return $(this).attr('data');
                }).get();
                var supplier_id = $("input.itemcheckbox:checked").map(function() {
                    return $(this).attr('data-supplier-id');
                }).get();
            }

            var item_name = item_name;
            var SupplierId = supplier_id;
            var product_sku = checkedBoxes;
            var orderId = {{ $orderId }};

            // $('#modalMain').modal('show');

            $.ajax({
                type: "POST",
                url: "{{ route('createTrackingModalData') }}",
                data: {
                    orderId,
                    item_name,
                    SupplierId,
                    product_sku
                },
                dataType: 'html',
                success: function(res) {
                    $("#modalData").html(res);
                    $('#modalMain').modal('show');

                },
                error: function(res) {


                }
            });
            // var len = $("input.itemcheckbox:checked").length;

            // if (checkedBoxes == '' || len > 1) {
            //     alert('To create tracking details please select only one item from Order Items');
            //     return false;
            // } else {
            //     var data = $("input.itemcheckbox:checked").attr('data');
            //     var data_supplier_id = $("input.itemcheckbox:checked").attr('data-supplier-id');
            //     $("#itemName").val(data);
            //     $("#SupplierId").val(data_supplier_id);
            //     $("#product_sku").val(checkedBoxes);
            //     $('#modalMain').modal('show');
            // }
        });
        $('button[id~="editShipping123"]').click(function() {
            $('#modalMain').modal('show');
        });

        $('#closeButton').click(function() {
            $('#modalMain').modal('hide');
        });

        //end of control tracking form 

        function changeTicketStatus(id, status) {
            if (alert(status) == true) {
                let updateStatus = status;
                let orderNumber = $('#orderNum').val();
                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ route('updateTicketStatus') }}",
                    data: {
                        id,
                        updateStatus,
                        orderNumber
                    },
                    dataType: 'json',
                    success: function(res) {
                        window.location.reload();
                        $("#updateResult").append(
                            '<div class="alert alert-success" role="alert"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>Successfully update ticket status</div>'
                        );
                    },
                    error: function(res) {
                        window.location.reload();
                        $("#updateResult").append(
                            '<div class="alert alert-danger" role="alert"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>Failed to update ticket status</div>'
                        );

                    }
                });
                // hideNotification();
            }
        }

        //finish working this order


        function finishWorkingOrder() {
            let orderId = $('#orderNum').val();

            $.ajax({
                type: "put",
                url: "{{ route('finishWorkingOrder') }}",
                data: {
                    orderId
                },
                dataType: 'json',
                success: function(data) {
                    window.location.assign(
                        "{{ route('fetchAllOrders') }}");
                }
            })
        };


        //Control comment modal

        $('#createCommentForm').on('submit', function(e) {



            let orderNumber = $('#orderNum').val();
            // ajax
            let comment = $('#comment').val();


            $.ajax({
                type: "POST",
                url: "{{ route('createOrderComment') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    orderNumber,
                    comment

                },
                dataType: 'json',
                success: function(res) {
                    window.location.reload();
                    $("#updateResult").append(
                        '<div class="alert alert-success" role="alert"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>Successfully create an comment</div>'
                    );


                },
                error: function(res) {

                    window.location.reload();
                    $("#updateResult").append(
                        '<div class="alert alert-danger" role="alert"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>Failed to create an comment</div>'
                    );

                }
            });
            hideNotification();

        });

        $('#submitEmailCustomerButton').click(function() {
            let subject = $('#emailCustomerSubject').val();
            let body = $('#emailCustomerBody').val();
            let from = $('#emailCustomerFrom').val();
            let link = $('#emailCustomerLink').val();
            $.ajax({
                type: "POST",
                url: "{{ route('emailCustomer', ['orderNumber' => $orderId]) }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    body,
                    from,
                    subject,
                    link
                },
                dataType: 'json'


            });

        });
        $(document).ajaxStart(function() {
            this.querySelector('#loading_spinner').classList.remove('d-none');
        });

        $(document).ajaxStop(function() {
                this.querySelector('#loading_spinner').classList.add('d-none');
            }

        );

        $('#ticketModalButton').click(function() {
            $('#modalTicket').modal('show');
        });
        $('#ticketCloseButton').click(function() {
            $('#modalTicket').modal('hide');

        });

        $('#emailCustomerButton').click(function() {
            $('#emailCustomerModal').modal('show');
        });
        $('#closeEmailCustomerButton').click(function() {
            $('#emailCustomerModal').modal('hide');
        });

        $('#modal_Button').click(function() {
            $('#modal_Main').modal('show');
        });
        $('#close_Button').click(function() {
            $('#modal_Main').modal('hide');
        });

        // function createTicketForm(orderId) {
        $('#createTicketForm').on('submit', function(e) {

            let order_number = $('#orderNum').val();
            // ajax
            let subject = $('#subject').val();
            let due_date = $('#due_date').val();
            let status = $('#status').val();
            let notes = $('#notes').val();
            // let type = $('#ticketType').val();
            // e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('createTicket') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    order_number,
                    subject,
                    due_date,
                    status,
                    notes
                    // ,
                    // type

                },
                dataType: 'json',
                success: function(res) {
                    window.location.reload();
                    $("#updateResult").append(
                        '<div class="alert alert-success" role="alert"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>Successfully create a ticket</div>'
                    );


                },
                error: function(res) {
                    window.location.reload();
                    $("#updateResult").append(
                        '<div class="alert alert-danger" role="alert"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>Failed to create a ticket</div>'
                    );

                }
            });
            hideNotification();

        });
    </script>
@endpush
