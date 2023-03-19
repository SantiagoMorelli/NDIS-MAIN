@extends('admin.layouts.app')
@section('title', 'Send email to supplier')
@section('content')

    <!-- .page -->
    <div class="page has-sidebar has-sidebar-expand-xl">
        <!-- .page-inner -->
        <div class="page-inner">
            <!-- .page-title-bar -->
            <header class="page-title-bar">
                <h1 class="page-title">Requesting ETA Update on Products on Backorder </h1>

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
                        <form action="{{ route('emailSupplierETA', ['supplier_id' => $supplier_id]) }}" method="POST">
                            @csrf

                            <h5 class="pb-3"> Hi team,</h5>

                            <div class="leading-7 text-base form-group">

                                <p> Can we please check the ETAs for the following products - whether they have come in, or
                                    if the dates have been pushed back?</p>

                                <label> Products Sku </label> <br>

                                <label> 1 . </label><input type="text" placeholder="enter product sku"
                                    class="h-6 rounded mx-1 w-48" name="product_sku[]" id="product_sku1" required><i
                                    class="text-red-400 pt-2">&#42;</i><br><br>

                                <label> 2 . </label><input type="text" placeholder="enter product sku"
                                    class="h-6 rounded mx-1 w-48" name="product_sku[]" id="product_sku2"><br><br>

                                <label> 3 . </label><input type="text" placeholder="enter product sku"
                                    class="h-6 rounded mx-1 w-48" name="product_sku[]" id="product_sku4"><br><br>

                                <label> 4 . </label><input type="text" placeholder="enter product sku"
                                    class="h-6 rounded mx-1 w-48" name="product_sku[]" id="product_sku3">

                                <br><br>
                                <p> If you can get back to us on this, that would be greatly appreciated.</p>
                                <p> Thank you.</p>



                                <br>
                                Kind regards,
                                <br>
                                {{ config('app.signature') }}
                            </div>

                            <!-- .form-actions -->
                            <div class="form-actions">
                                <a href="{{ route('getSuppliersPage') }}">
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
