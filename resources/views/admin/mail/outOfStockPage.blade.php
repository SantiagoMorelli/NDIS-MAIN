@extends('admin.layouts.app')
@section('title', 'out of stock email')
@section('content')

    <!-- .page -->
    <div class="page has-sidebar has-sidebar-expand-xl">
        <!-- .page-inner -->
        <div class="page-inner">
            <!-- .page-title-bar -->
            <div class="fixed flex justify-end bg-red-50 top-2 left-2/4 " style="z-index: 9999;">
                <button class="btn btn-primary border-0 rounded-0 "><span class="text-base">Order
                        : {{ $orderData['order_number'] }} </span></button>
            </div>
            <header class="page-title-bar">
                <h1 class="page-title"> Out of stock email</h1>
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
                        <!-- succes - error messages -->
                        <x-authenticate-result />
                        <!-- /succes - error messages -->
                        <!-- form .needs-validation -->
                        <form action="{{ route('outOfStockSend', ['orderNumber' => $orderData['order_number']]) }}"
                            method="POST">
                            @csrf
                            <input type="hidden" name="order_number" value="{{ $orderData['order_number'] }}">
                            {{-- <input type="hidden" name="id" value="{{ $supplierData->supplier_id }}"> --}}
                            {{-- <input type="hidden" name="order_number" value="{{ $supplierData->order_id }}"> --}}

                            {{-- <div class="pb-2">
                                <label for="from" class="text-base">send email from </label>
                                {{-- <input type="text" name="from" id="from"
                                    class="h-6 rounded mx-1 w-32" required> --}}
                            {{-- <select name="from" id="from" class="h-9 rounded mx-1 w-fit">
                                    <option value="customercare@bettercaremarket.com.au" selected> My personal account
                                    </option>
                                    <option value="thdashuaib@gmail.com"> 1</option>
                                    <option value="thdashuaib@gmail.com"> 2</option>

                                </select>
                            </div>
                            <hr> --}}

                            <h5 class="pb-3"> Hey {{ $orderData['customer_first_name'] }},</h5>

                            <div class="leading-7 text-base form-group">


                                <p>Your recent order of the<br>
                                    <?php
                                    foreach ($name as $key => $value) {
                                        echo '<input type="text" placeholder="product Name" value="' . $value['item_name'] . '" class="h-6 rounded mx-1 w-52" name="product[]" id="product" style="color:black" required><i class="text-red-400 pt-2">&#42;</i><br>';
                                    } ?>
                                    <br>is/are currently
                                    out of stock.
                                    Our supplier is expecting
                                    the item to be back in
                                    stock by <input type="date" placeholder="date" name="date" id="date"
                                        class="h-6 rounded w-40 mx-1" required><i class="text-red-400 pt-2">&#42;</i>
                                    .
                                </p>
                                <p>
                                    They’re doing everything they can to send it out as soon as possible once the shipment
                                    arrives in their warehouse.
                                </p>
                                <p>We thank you for your patience!</p>
                                <br>
                                Best regards, <br>

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
