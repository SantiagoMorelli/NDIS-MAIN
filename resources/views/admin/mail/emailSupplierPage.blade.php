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
                        <form action="{{ route('emailSupplier', [$supplierData['supplier_id']]) }}" method="POST">
                            @csrf
                            <h5 class="pb-3"> Hi {{ $supplierData['supplier_name'] }},</h5>
                            <div>
                                <label>Subject </label> <input type="text" placeholder="enter subject"
                                    class="h-6 rounded mx-1 " style="width:350px;  color:black;" name="subject"
                                    value="" id="subject" required><i class="text-red-400 pt-2">&#42;</i>
                            </div><br>


                            <div class="leading-7 text-base form-group">
                                <div>
                                    <textarea class="h-6 rounded mx-1 w-48" placeholder="enter mail body" name="body"
                                        style="width:auto;height:200px; color:black;" rows="4" cols="50" required></textarea>
                                    <i class="text-red-400 pt-2">&#42;</i>
                                </div><br>
                                Warm regards,
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
