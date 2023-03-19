@extends('admin.layouts.app')
@section('title', 'Orders')
@section('content')
    @php
        $orderStatus = config('ndis.newOrderStatus');
        $ndisType = config('ndis.newNidsType');
    @endphp
    <!-- .page -->
    <div class="page">

        <!-- .page-inner -->
        <div class="page-inner">
            <!-- .page-title-bar -->
            <header class="page-title-bar">
                <!-- title -->
                <h1 class="page-title">All Orders</h1>


                <div id='loading_spinner' style="z-index: 10000" class="spinner-grow text-primary d-none inset-1/2 fixed "
                    role="status">
                    <span class="sr-only ">Loading...</span>
                </div>
                <!-- Autheticate result -->

                <div id='updateResult' class="fixed top-16 w-3/6" style="z-index: 1000000;">
                    <x-authenticate-result />
                </div>



                @php
                    $alerts = json_decode($alertArray);
                    $alertNumber = count($alerts);
                    
                @endphp

                @if (!empty($alerts))

                    <div class="alert alert-danger " role="alert">
                        <div>
                            <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="fa fa-times"></i>
                            </button>

                            <h5> Today's task <span class="badge badge-pill badge-danger">{{ $alertNumber }}</span></h5>
                            <div class='flex justify-evenly  pt-2 overflow-y-auto w-full flex-wrap h-40'>
                                @foreach ($alerts as $alert)
                                    @php
                                        $changeTicket = 'changeTicketStatus(' . $alert->id . ",'closed')";
                                    @endphp
                                    <div class="alert inline-block max-w-lg h-20 overflow-y-auto py-2 ml-3" role="alert">
                                        <button data-dismiss="alert" class="close close-sm" type="button">
                                            <i class="ml-2 fa fa-times"></i>
                                        </button>

                                        <div class="max-w-md w-44">
                                            <ul>
                                                <li>
                                                    @if ($alert->type == '1')
                                                        <a href={{ route('getOneTicket', ['ticketId' => $alert->id]) }}>Task
                                                            Id : {{ $alert->id }}</a>
                                                    @elseif($alert->type == '2')
                                                        <a href={{ route('getTicketDetails', ['ticketId' => $alert->id]) }}>Ticket
                                                            Id : {{ $alert->id }}</a>
                                                    @elseif($alert->type == '0' || !$alert->type)
                                                        <a
                                                            href={{ route('viewOrderDetails', ['id' => $alert->order_number]) }}>Order
                                                            Num :
                                                            {{ $alert->order_number }}</a>
                                                    @endif
                                                    <button onclick={{ $changeTicket }}><input type="checkbox"
                                                            checked></input></button>
                                                </li>
                                                <li>
                                                    Subject : {{ $alert->subject }}</li>
                                                <li> Created : {{ date('Y-m-d', strtotime($alert->created_at)) }}
                                                </li>

                                            </ul>

                                        </div>
                                        {{-- @endif --}}

                                    </div>
                                @endforeach


                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info" role="alert">
                        No Tasks today!
                    </div>
                @endif




            </header><!-- /.page-title-bar -->
            <!-- .page-section -->
            <div class="page-section">
                <!-- .card -->
                <div class="card card-fluid">
                    <!-- .card-body -->
                    <div class="card-body">


                        <!-- .Filter section -->

                        <x-filter-procedure class="ml-9" />

                        <form method="GET" id="search-form" role="form">
                            @csrf

                            {{-- filter section --}}
                            <x-filter />
                            {{-- Submit section --}}
                            <div class='flex justify-center '>
                                <button type="submit"
                                    class=" bg-blue-500 hover:bg-blue-600 focus:outline-none text-white font-bold py-2 px-4 rounded mr-4">Filter</button>
                                <button type="reset"
                                    class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mr-4">Clear</button>
                            </div>



                        </form>

                    </div>
                </div>
                {{-- <div class="relative"> --}}
                {{-- <div class="relative inset-x-2/4 " style="top:2rem;">
                    <x-create-ticket-modal />
                </div> --}}
                <x-create-ticket-modal />
                {{-- </div> --}}

                <div style="min-height: 300px;">
                    <table id="orderlist-datatable" class="table dt-responsive nowrap w-100 mt-2 pb-24">
                        <thead>
                            <tr>
                                <th> Order No. </th>
                                <th> Order Date </th>
                                <th> Processing Status </th>
                                <th> Customer Name </th>
                                <th> Working </th>
                                <th> Action </th>
                                <th> Shipping Address</th>
                                {{-- <th> Order Total </th> --}}
                                <th> End User Name </th>
                                <th> Ndis </th>
                                <th> Payment Method</th>

                            </tr>
                        </thead>
                    </table><!-- /.table -->
                </div>

            </div><!-- /.page-section F-->
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
        var order_status = $('#order_status');
        var payment = $('#payment');
        var category = $('#category');
        var table = $('#orderlist-datatable').DataTable({
            pageLength: 25,
            processing: true,
            serverSide: true,
            order: [
                [1, 'desc'],
                [4, 'desc']
            ],
            ajax: {
                url: '{{ route('filteredOrders') }}',
                data: function(d) {
                    d.order_status = $('#order_status').val();
                    d.start_date = $('input[name=start_date]').val();
                    d.end_date = $('input[name=end_date]').val();
                    d.payment = $('#payment').val();
                    d.category = $('#category').val();
                    d.shipping_address = $('#shipping_address').val();
                    d.order_status_secondary = $('#order_status_secondary').val();
                    d.supplier_invoice = $('#supplier_invoice').val();

                }
                // success: function(res) {
                //     // res = JSON.parse(res);
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
                    width: '6%',
                    data: 'order_number'
                },
                {
                    width: '6%',
                    data: 'order_date'
                },
                {
                    width: '6%',
                    data: 'order_status'
                },
                {
                    width: '3%',
                    data: 'customer_name',
                    render: function(data, type, row) {
                        return (`<span class="w-28 inline-block" style="text-overflow: ellipsis; overflow:hidden;"> ${data}
                            </span>`);
                    }
                },
                {
                    width: '4%',
                    data: 'assign',
                    // orderable: false,
                    render: function(data, type, row) {
                        // return  data;
                        if (data == '1') {
                            return '<i class="fa fa-user text-red-300" aria-hidden="true"></i>'
                        } else if (data == '2') {
                            return '<span>&#10003;</span>'
                        } else if (data == '3') {
                            return `<span> Me </span><button class="pe-auto" onclick="finishWorkingOrder(${(row.order_number).toString()})"> <input type="radio" class="pe-auto" checked></input></button>`;
                            // `<button onclick=finishWorkingOrder(${row.order_number})> <input type="checkbox" checked></input></button>`;
                        }
                        return null;
                    }
                },
                {
                    with: "12%",
                    data: 'action',
                    orderable: false
                },

                {
                    data: 'shipping_address'
                },
                {
                    width: '3%',
                    data: 'shipping_address_name',
                    render: function(data, type, row) {
                        return (`<span class="w-28 inline-block" style="text-overflow: ellipsis; overflow:hidden;"> ${data}
                            </span>`);
                    }
                },
                // {
                //     data: 'order_total'
                // },
                {
                    data: 'ndis_type'
                },
                {
                    data: 'payment_option'
                },

            ]
        });
        // 4;payment Option ->8
        // 5shipping address
        //7: ndis_type_select
        //8 action : ->4
        const searchForm = $('#search-form');
        var submitClick = 0;
        searchForm.on('submit', function(e) {
            submitClick++;
            if ($('#payment').val()) table.columns(9).search($('#payment').val()).draw(false);
            if ($('#shipping_address').val()) table.columns(6).search($('#shipping_address').val()).draw(false);
            if ($('#ndis_type_select').val()) table.columns(8).search($('#ndis_type_select').val()).draw(false);
            // table.search('').draw();
            table.columns(8).search($('#ndis_type_select').val()).draw(false)
            e.preventDefault();

        });
        searchForm.on('reset', function(e) {
            const search_date = document.querySelectorAll('#filterCriteria input');

            $('#order_status').selectedIndex = 0;
            document.querySelector('#category').selectedIndex = 0;
            document.querySelector('#payment').selectedIndex = 0;
            document.querySelector('#ndis_type_select').selectedIndex = 0;
            document.querySelector('#order_status').selectedIndex = 0;
            document.querySelector('#order_status_secondary').selectedIndex = 0;
            search_date.forEach(date => date.value = '');
            if (submitClick % 2 == 1) {
                table.column(9).search('').draw();
                table.column(6).search('').draw();
                table.column(8).search('').draw();
                table.search('').draw();

            }
            submitClick = 0;
            e.preventDefault();

        });

        $('#ndis_order').click(function(e) {
            document.querySelector('#category').selectedIndex = 1;
            e.preventDefault();

        });

        const paymentType = document.querySelector('#payment');
        const ndisType = document.querySelector('#ndis_type_select');


        $('#ticketModalButton').click(function() {
            $('#modalTicket').modal('show');
        });
        $('#ticketCloseButton').click(function() {
            $('#modalTicket').modal('hide');

        });
        //#non_ndis_procedure
        $('#filterProcedure li').click(function(e) {
            let targetClassName = e.target.className.toString();
            let Order_type = e.target.id.toString().split('_')[0].toLowerCase();
            if (targetClassName.includes('status_')) {
                const status_no = targetClassName.slice(-1);
                document.querySelector('#order_status').selectedIndex = (parseInt(status_no) + 1);
                switch (Order_type) {
                    case 'ndia':
                        ndisType.selectedIndex = 1;
                        break;
                    case 'plan':
                        ndisType.selectedIndex = 2;
                        break;
                    case 'self':
                        ndisType.selectedIndex = 3;
                        break;
                    case 'afterpay':
                        paymentType.selectedIndex = 1;
                        break;
                    case 'paypal':
                        paymentType.selectedIndex = 2;
                        break;
                    case 'eway':
                        paymentType.selectedIndex = 3;
                        break;
                    case 'admin':
                        paymentType.selectedIndex = 4;
                        break;

                }

            }

            d.preventDefault();


        });

        function workOnOrder(id) {
            if (confirm("Are you sure that you want to work on this order")) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('assignOrderTo') }}",
                    data: {
                        id
                    },
                    dataType: 'json',
                    success: function(res) {
                        // window.location.assign(
                        //     "{{ route('fetchAllOrders') }}");
                        let oTable = $('#orderlist-datatable').dataTable();
                        oTable.fnDraw(false);
                        $("#updateResult").append(
                            '<div class="alert alert-success" role="alert"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>You can work on order now </div>'

                        );
                    }
                });
                hideNotification();
            }
        }

        function finishWorkingOrder(orderId = null) {

            if (confirm("Are you sure that you finish working on this order")) {
                $.ajax({
                    type: "put",
                    url: `{{ route('finishWorkingOrder') }}`,
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
        };


        function changeOrderStatus(id, status) {
            if (confirm("Are you sure you want to update order status?") == true) {

                let updateStatus = status;
                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ route('updateOrdersStatus') }}",
                    data: {
                        id,
                        updateStatus
                    },

                    success: function(res) {
                        res = JSON.parse(res);
                        //  console.log(res);
                        var oTable = $('#orderlist-datatable').dataTable();
                        oTable.fnDraw(false);
                        if (res.status == 1) {
                            $("#updateResult").append(
                                '<div class="alert alert-success alert-timer" role="alert"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>' +
                                res.message + '</div>'
                            );


                        } else {
                            $("#updateResult").append(
                                '<div class="alert alert-success alert-timer" role="alert"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>' +
                                res.message + '</div>'
                            );
                        }

                    },
                    error: function() {
                        $("#updateResult").append(
                            '<div class="alert alert-danger" role="alert"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button> fail to update status </div>'

                        );
                    }


                });
                hideNotification();
            }
        };





        $(document).ajaxStart(function() {
            this.querySelector('#loading_spinner').classList.remove('d-none');
        });

        $(document).ajaxStop(function() {
                this.querySelector('#loading_spinner').classList.add('d-none');
            }

        );

        // function createTrackingForm(orderId) {
        $('#createTicketForm').on('submit', function(e) {

            let order_number = $('#orderId').val();
            // ajax
            let subject = $('#subject').val();
            let due_date = $('#due_date').val();
            let status = $('#status').val();
            let notes = $('#notes').val();
            // let type = $('#ticketType').val();

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


                },
                dataType: 'json',
                success: function() {
                    window.location.assign(
                        "{{ route('fetchAllOrders') }}");
                    $("#updateResult").append(
                        '<div class="alert alert-success" role="alert"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button> Successfully create a ticket </div>'

                    );
                },
                error: function() {
                    window.location.assign(
                        "{{ route('fetchAllOrders') }}");
                    $("#updateResult").append(
                        '<div class="alert alert-danger" role="alert"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button> fail to create a ticket, please try again </div>'

                    );
                }
            });
            hideNotification();

        });

        function changeTicketStatus(id = null, status = null) {
            if (confirm("Are you sure to update ticket status?") == true) {
                var id = id;
                let updateStatus = status;
                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ route('updateTicketStatus') }}",
                    data: {
                        id,
                        updateStatus
                    },
                    dataType: 'json',
                    success: function(res) {
                        window.location.assign("{{ route('fetchAllOrders') }}");
                        $("#updateResult").append(
                            '<div class="alert alert-success" role="alert"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>Successfully updated the ticket status</div>'
                        );
                    },
                    error: function() {
                        window.location.assign("{{ route('fetchAllOrders') }}");
                        $("#updateResult").append(
                            '<div class="alert alert-danger" role="alert"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>Faailed to update the ticket status, please try again!</div>'
                        );
                    }
                });
                hideNotification();
            }
        }
    </script>
@endpush
