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
                        : {{ $data['order_id'] }} </span></button>

            </div>
            <header class="page-title-bar">
                <h1 class="page-title"> Requesting tracking details from supplier</h1>

                {{-- print success / error message here --}}
                <x-authenticate-result />



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

                        <!-- form .needs-validation -->
                        <form action="{{ route('emailSupplierTracking', ['supplier_id' => $supplier_id]) }}" method="POST">
                            @csrf

                            <h5 class="pb-3"> Hi team,</h5>

                            <div class="leading-7 text-base form-group">

                                <p> Can you please send us the tracking number for order below</p>

                                <label>Order No</label>
                                <input type="text" placeholder="enter order number" class="h-6 rounded mx-1 w-48"
                                    name="orderNumber" value="{{ $data['order_id'] }}" id="orderNumber" required><i
                                    class="text-red-400 pt-2">&#42;</i>
                                <br>

                                <label>Customer Name </label>
                                <input type="text" placeholder="enter customer name" class="h-6 rounded mx-1 w-48"
                                    name="custemer_name"
                                    value="{{ ucfirst($data['customer_first_name']) }}  {{ ucfirst($data['customer_last_name']) }}"
                                    id="custemer_name" required><i class="text-red-400 pt-2">&#42;</i>
                                <br>


                                <p> so we can update them on their order? </p>
                                <p> Thank you.</p>



                                <br>
                                Kind regards,
                                <br>
                                {{ config('app.signature') }}
                            </div>

                            <!-- .form-actions -->
                            <div class="form-actions">
                                <a href="{{ route('viewOrderDetails', ['id' => $data['order_id']]) }}">
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
