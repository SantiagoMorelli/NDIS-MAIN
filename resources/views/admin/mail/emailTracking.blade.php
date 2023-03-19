@extends('admin.layouts.app')
@section('title', 'send tracking info')
@section('content')

    <!-- .page -->
    <div class="page has-sidebar has-sidebar-expand-xl">
        <!-- .page-inner -->
        <div class="page-inner">
            <!-- .page-title-bar -->
            <header class="page-title-bar">
                <h1 class="page-title"> Send tracking info</h1>
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
                        <x-authenticate-result />

                        <!-- /succes - error messages -->
                        <!-- form .needs-validation -->
                        <form action="{{ route('emailTrackingInfo', ['orderNumber' => $orderData['order_number']]) }}"
                            method="POST">
                            @csrf
                            <input type="hidden" name="order_number" value="{{ $orderData['order_number'] }}">
                            <h5 class="pb-3"> Hey {{ $orderData['customer_first_name'] }},</h5>

                            <div class="leading-7 text-base form-group">

                                <p> We are pleased to inform you that the following product(s) are currently being prepared
                                    for dispatch:</p>
                                {{-- <p> Product - <input type="text" placeholder="product Name"
                                        class="h-6 rounded mx-1 w-32 max-w-2xl" name="product" id="product" required><i
                                        class="text-red-400 pt-2">&#42;</i>
                                </p> --}}

                                <table class="table">
                                    <thead>
                                        <tr>

                                            <th scope="col">Product</th>
                                            <th scope="col">Tracking code</th>
                                            <th scope="col"> Link </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($trackingData as $data)
                                            <tr>

                                                <td><input type="text" placeholder="enter name"
                                                        value="{{ $data['item_name'] }}" style="color:black; width: 375px;"
                                                        class="h-7 rounded" name="product1" id="product1" required><i
                                                        class="text-red-400 pt-2">&#42;</i></td>
                                                <td><input type="text" placeholder="enter code"
                                                        value="{{ $data['tracking_number'] }}" style="color:black"
                                                        class="h-7 rounded mx-1 w-36 max-w-2xl" name="tracking1"
                                                        id="tracking1" required><i class="text-red-400 pt-2">&#42;</i></td>
                                                <td><input type="text" placeholder="enter link" style="color:black"
                                                        class="h-7 rounded mx-1 w-36 max-w-2xl" name="link1"
                                                        id="link1" value=""></td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>

                                {{-- <p>
                                    Tracking Number -
                                    <input type="text" placeholder="please enter" name="date" id="date"
                                        class="h-6 rounded w-32 mx-1 max-w-2xl" required><i
                                        class="text-red-400 pt-2">&#42;</i>

                                </p> --}}
                                <p>
                                    Click on the tracking number to check the progress through .
                                </p>
                                <p>Please don't hesitate to contact us if you have any queries, or if you would like a
                                    further update. </p>

                                Thank you for shopping with us!
                                <br><br>
                                Warm regards,
                                <br>
                                {{ config('app.signature') }}

                            </div>


                            <!-- .form-actions -->
                            <div class="form-actions">
                                <a href="{{ route('viewOrderDetails', ['id' => $orderData['order_number']]) }}">
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
