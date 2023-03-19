@extends('admin.layouts.app')
@section('title', 'Plan Managed Orders')
@section('content')
    <!-- .page -->
    <div class="page">
        <!-- .page-inner -->
        <div class="page-inner">
            <!-- .page-title-bar -->
            <header class="page-title-bar">

                <!-- title -->
                <h1 class="page-title">Plan Managed Orders</h1>
                <!-- succes - error messages -->
                @if (session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        <button data-dismiss="alert" class="close close-sm" type="button">
                            <i class="fa fa-times"></i>
                        </button>
                        {{ session()->get('success') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger" role="alert">
                        <button data-dismiss="alert" class="close close-sm" type="button">
                            <i class="fa fa-times"></i>
                        </button>
                        {{ session()->get('error') }}
                    </div>
                @endif
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                            {{ $error }}
                        </div>
                    @endforeach
                @endif
                <!-- /succes - error messages -->
            </header><!-- /.page-title-bar -->
            <!-- .page-section -->
            <div class="page-section">
                <!-- .card -->
                <div class="card card-fluid">
                    <!-- .card-body -->
                    <div class="card-body">

                        <!-- .table -->
                        <table id="orderlist-datatable" class="table dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th> Order No. </th>
                                    <th> Order Date </th>
                                    <th> Processing Status </th>
                                    <th> Customer Name </th>
                                    <th> Shipping Total </th>
                                    <th> Gst Total </th>
                                    <th> Order Total </th>
                                    <th> Action </th>
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
        var table = $('#orderlist-datatable').DataTable({
            pageLength: 25,
            processing: true,
            serverSide: true,
            ajax: "{{ route('getPlanManagedOrders') }}",
            responsive: true,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>\n        <'table-responsive'tr>\n        <'row align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 d-flex justify-content-end'p>>",
            language: {
                paginate: {
                    previous: '<i class="fa fa-lg fa-angle-left"></i>',
                    next: '<i class="fa fa-lg fa-angle-right"></i>'
                }
            },
            columns: [{
                    data: 'order_number',
                    /*render:function(data, type, row, meta){
                                   data = "<a href={{ url('admin/order/view') }}/" + row.id + ">" + row.order_number+ "</a>";
                                  return data;
                    }*/
                },
                {
                    data: 'order_date'
                },
                {
                    data: 'order_status'
                },
                {
                    data: 'customer_name'
                },
                {
                    data: 'shipping_total',
                    orderable: false
                },
                {
                    data: 'gst_total',
                    orderable: false
                },
                {
                    data: 'order_total',
                    orderable: false
                },
                {
                    data: 'action',
                    orderable: false
                },
            ],
            order: [
                [1, 'desc']
            ]
        });

        function changeOrderStatus(id) {
            if (confirm("Are you sure to update order as Paid?") == true) {
                var id = id;
                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ route('updateOrderStatus') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(res) {
                        var oTable = $('#orderlist-datatable').dataTable();
                        oTable.fnDraw(false);
                    }
                });
            }
        }
    </script>
@endpush
