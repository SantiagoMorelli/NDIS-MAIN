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
                        : {{ $orderNumber }} </span></button>

            </div>
            <header class="page-title-bar">
                <h1 class="page-title"> Send email to supplier for order update</h1>

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
                        <form action="{{ route('emailSupplierOrderUpadte', ['supplier_id' => $supplier_id]) }}"
                            method="POST">
                            @csrf

                            <h5 class="pb-3"> Hi team,</h5>

                            <div class="leading-7 text-base form-group">

                                <p> Can you please update us on the status of following order </p>
                                <label>Order No</label>
                                <input type="text" placeholder="enter order number" class="h-6 rounded mx-1 w-48"
                                    name="orderNumber" value="{{ $orderNumber }}" id="orderNumber" required><i
                                    class="text-red-400 pt-2">&#42;</i>
                                <br>

                                <p> - whether this has been dispatched? </p>

                                <p>
                                    The customer is following up on this order, and we’d love to give them some more
                                    information on its progress. </p>

                                <p> If you can please get back to us on this, that would be greatly appreciated.</p>

                                <br>
                                Kind regards,
                                <br>
                                {{ config('app.signature') }}
                            </div>

                            <!-- .form-actions -->
                            <div class="form-actions">
                                <a href="{{ route('viewOrderDetails', ['id' => $orderNumber]) }}">
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
