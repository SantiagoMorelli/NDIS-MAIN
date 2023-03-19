@extends('admin.layouts.app')
@section('title', 'long delay email')
@section('content')

    <!-- .page -->
    <div class="page has-sidebar has-sidebar-expand-xl">
        <!-- .page-inner -->
        <div class="page-inner">
            <!-- .page-title-bar -->
            <header class="page-title-bar">
                <h1 class="page-title"> Long delay email</h1>
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
                        <form action="{{ route('longDelaySend', ['orderNumber' => $orderData['order_number']]) }}"
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
                                    <option value="thdashuaib@gmail.com" selected> My personal account</option>
                                    <option value="thdashuaib@gmail.com"> 1</option>
                                    <option value="thdashuaib@gmail.com"> 2</option>

                                </select>
                            </div>
                            <hr> --}}

                            <h5 class="pb-3"> Hey {{ $orderData['customer_first_name'] }},</h5>

                            <div class="leading-7 text-base form-group">


                                <p>Unfortunately, we just been informed by our supplier that <br>

                                    <?php
                                    foreach ($name as $key => $value) {
                                        echo '<input type="text" placeholder="product Name" value="' .
                                            $value['item_name'] .
                                            '"
                                                                                                                                                                                                                                                                                                                                                class="h-6 rounded mx-1 w-52" name="product[]" id="product" style="color:black" required>
                                                                                                                                                                                                                                                                                                                                                <i class="text-red-400 pt-2">&#42;</i><br>';
                                    } ?>
                                    <br>

                                    is out of stock until
                                    <input type="date
                                    " placeholder="date"
                                        name="date" id="date" class="h-6 rounded w-32 mx-1" required>
                                    <i class="text-red-400 pt-2">&#42;</i>
                                    .
                                </p>
                                <p>
                                    Please let us know if you are happy to wait and we will let you know of any changes.
                                </p>
                                <p>If you would prefer a refund for this item, feel free to contact us.</p>
                                <p>We thank you for your patience!</p>
                                <br>
                                Best regards,

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
