@extends('admin.layouts.app')
@section('title', 'View All Tickets')
@section('content')

    <!-- .page -->
    <div class="page">
        <!-- .page-inner -->
        <div class="page-inner">
            <!-- .page-title-bar -->
            <header class="page-title-bar">
                <legend>
                    <h5>Tickets & Tasks </h5>
                </legend>
                <!-- title -->

                {{-- <div class="flex justify-between">
                    <h1 class="page-title">Tickets & Tasks</h1>
                    <div id="changeInterval" class="hidden">
                        <label for="changeCheckingInterval"> change checking interval</label>
                        <br>
                        <input id="changeCheckingInterval" class="rounded w-24 h-7" name="changeCheckingInterval"
                            type="number" required min=1 placeholder={{ $currentInterval }}> </input>
                        <button onclick="changeCheckingInterval()" class="btn btn-success btn-xs">Change</button>
                    </div>
                </div> --}}

                <div id="updateResult"></div>



                <!-- Autheticate result -->
                <div id='updateResult' class="fixed top-16 w-3/6" style="z-index: 1000000;">
                    <x-authenticate-result />
                </div>

            </header><!-- /.page-title-bar -->
            <!-- .page-section -->
            <div class="page-section">
                <!-- .card -->
                <div class="card card-fluid">
                    <!-- .card-body -->
                    <div class="card-body">
                        <x-create-ticket-modal />
                        <div id='loading_spinner' style="z-index: 10000"
                            class="spinner-border text-danger d-none inset-1/2 fixed " role="status">
                            <span class="sr-only ">Loading...</span>
                        </div>
                        {{-- <div style="max-width: 50% !important;">> --}}
                        <div>
                            @if (isset($ticketId))
                                <input type="hidden" id="ticketId" value={{ $ticketId }}></input>
                            @endif

                            <table id="ticket_datatable" class="table dt-responsive nowrap w-100 mt-2 border-2">
                                <thead>
                                    <tr>

                                        <th> Subject </th>
                                        <th> Status </th>
                                        <th> TId </th>
                                        <th> ONumber </th>
                                        <th> Due Date </th>
                                        {{-- <th> Create Time </th> --}}
                                        {{-- <th> Notes</th> --}}

                                        <th> Action </th>
                                    </tr>
                                </thead>
                            </table><!-- /.table -->
                        </div>





                    </div>
                </div>




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
        var table = $('#ticket_datatable').DataTable({
            pageLength: 10,
            processing: true,
            serverSide: true,
            order: [
                [4, 'desc']
            ],
            ajax: {
                url: "{{ route('getAllTickets') }}",
                data: function(d) {
                    d.ticketId = $('#ticketId').val() || null;
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
                    width: "15%",
                    data: 'subject'
                },
                {
                    width: "10%",
                    data: 'status',
                    render: function(data, type, row) {

                        if (data == 'closed') {
                            return '<div class=" badge bg-success text-white"> closed </div>';
                        } else if (data == 'open') {
                            return '<div class="badge bg-danger text-white"> open </div>';
                        } else if (data == 'processing') {
                            return "<div class='badge bg-warning text-white'> processing </div>";
                        } else {
                            return 'error';
                        }

                    }

                },
                {
                    width: "10%",
                    data: 'id'
                },
                {
                    width: "8%",
                    data: 'order_number'
                },
                {
                    data: 'due_date'
                },
                // {
                //     data: 'created_at'
                // },
                {
                    data: 'action',
                    orderable: false
                },
            ]
        });
        $(document).ajaxStart(function() {
            this.querySelector('#loading_spinner').classList.remove('d-none');
        });

        $(document).ajaxStop(function() {
                this.querySelector('#loading_spinner').classList.add('d-none');
            }

        );
        // function createTrackingForm(orderId) {
        $('#createTicketForm').on('submit', function(e) {
            // e.preventDefault();
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
                    // ,
                    // type

                },
                dataType: 'json',

                success: function(res) {
                    window.location.reload();
                    $("#updateResult").append(
                        '<div class="alert alert-success" role="alert"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>Successfully created a ticket</div>'
                    );
                },
                error: function(res) {
                    window.location.reload();
                    $("#updateResult").append(
                        '<div class="alert alert-danger" role="alert"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>Failed to create a ticket</div>'
                    );
                }

            });
            // hideNotification();

        });



        $('#ticketModalButton').click(function() {
            $('#modalTicket').modal('show');
        });
        $('#ticketCloseButton').click(function() {
            $('#modalTicket').modal('hide');
        });








        function changeCheckingInterval() {
            let interval = $('#changeCheckingInterval').val();
            if (confirm("Are you sure you wanna change checking interval?") == true) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('changeCheckingInterval') }}",
                    data: {
                        interval
                    },
                    dataType: 'json',
                    success: function(res) {
                        $("#updateResult").append(
                            '<div class="alert alert-success" role="alert"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>Successfully update the checking interval</div>'
                        );
                    },
                    error: function(res) {
                        $("#updateResult").append(
                            '<div class="alert alert-danger" role="alert"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>Successfully update the checking interval</div>'
                        );
                    }
                });
                //  hideNotification();
            }
        }


        function changeTicketStatus(id = null, status = null) {
            if (confirm("Are you sure you wanna update the ticket status?") == true) {
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
                        // window.location.assign(
                        //     "{{ route('getTicketsPage') }}");
                        window.location.reload();
                        var oTable = $('#ticket_datatable').dataTable();
                        oTable.fnDraw(false);

                        $("#updateResult").append(
                            '<div class="alert alert-success" role="alert"><button data-dismiss="alert" class="close close-sm" type="button"><i class="fa fa-times"></i></button>Successfully update the status</div>'
                        );
                        // hideNotification();
                    }
                });

            }
        }
    </script>
@endpush
