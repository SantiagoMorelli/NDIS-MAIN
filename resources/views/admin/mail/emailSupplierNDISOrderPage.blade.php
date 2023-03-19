@extends('admin.layouts.app')
@section('title', 'Send email to supplier')
@section('content')

    <!-- .page -->
    <div class="page has-sidebar has-sidebar-expand-xl">
        <!-- .page-inner -->
        <div class="page-inner">
            <!-- .page-title-bar -->
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

                        <!-- get order data by order number -->
                        
                        <form id="getOneOrderData">
                            <input type="text" placeholder="enter order number" class="h-6 rounded mx-1 w-48"
                                name="orderNumber" id="orderNumber" required>
                            <input type="hidden" name="supplier_id" id="supplier_id" value="{{ $supplier_id }}">
                            <button class="btn btn-primary" type="submit">Get Order Data</button>
                        </form>


                        <br>
                        <!-- form .needs-validation -->
                        <form action="{{ route('emailSupplierNDISOrder', ['supplier_id' => $supplier_id]) }}"
                            method="POST">
                            @csrf

                            <h5 class="pb-3"> Hi team,</h5>

                            <div class="leading-7 text-base form-group">

                                <p> Can we please order the following :</p>

                                <div id="oneSupplierOrderData" class="card-body border-top">

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
                                <a href="{{ route('getAllSuppliers') }}">
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
