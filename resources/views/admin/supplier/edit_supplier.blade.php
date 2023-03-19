<?php
use App\Repositories\CommonRepository;
?>
@extends('admin.layouts.app')
@section('title', 'Edit Supplier')
@section('content')
    <!-- .page -->
    <div class="page has-sidebar has-sidebar-expand-xl">
        <!-- .page-inner -->
        <div class="page-inner">
            <!-- .page-title-bar -->
            <header class="page-title-bar">
                <h1 class="page-title"> Edit Supplier Information</h1>
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
                        <form id="editSupplier"
                            action="{{ route('editSupplier', ['supplierName' => $supplierData->supplier_name]) }}"
                            method="POST">
                            <input type="hidden" name="id" value="{{ $supplierData->supplier_id }}">
                            {{-- <input type="hidden" name="order_number" value="{{ $supplierData->order_id }}"> --}}

                            <!-- .form-row -->
                            <div class="form-row">
                                <!-- form grid -->
                                <div class="col-md-12 mb-3">
                                    <label for="supplier_name">Supplier Name</label> <input type="text"
                                        class="form-control" id="supplier_name" name="supplier_name"
                                        value="{{ $supplierData->supplier_name }}" disabled>

                                </div><!-- /form grid -->
                                <div class="col-md-12 mb-3">
                                    <label for="supplier_emailid">Supplier Email</label> <input type="text"
                                        class="form-control" id="supplier_emailid" name="supplier_emailid"
                                        placeholder="please enter supplier_emailid" aria-describedby="inputLastName"
                                        value="{{ $supplierData->supplier_emailid }}">

                                </div><!-- /form grid -->

                                <!-- form grid -->
                                <div class="col-md-12 mb-3">
                                    <label for="phone_number">Phone Number</label> <input type="text"
                                        class="form-control" id="phone_number" name="phone_number"
                                        aria-describedby="inputLastName" value="{{ $supplierData->phone_number }}">

                                </div><!-- /form grid -->
                                <div class="col-md-12 mb-3">
                                    <label for="contact_person">Contact Person</label> <input type="text"
                                        class="form-control" id="contact_person" name="contact_person"
                                        value="{{ $supplierData->contact_person }}">

                                </div><!-- /form grid -->
                                <div class="col-md-12 mb-3">
                                    <label for="note">Note</label> <input type="text" class="form-control"
                                        id="note" name="note" value="{{ $supplierData->note }}">

                                </div><!-- /form grid -->

                            </div><!-- /.form-row -->
                            <!-- .form-actions -->
                            <div class="form-actions">
                                <a href="{{ route('getSuppliersPage') }}">
                                    <button class="btn btn-secondary shadow-sm btn--sm mr-2" type="button">Cancel</button>
                                </a>
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div><!-- /.form-actions -->
                        </form><!-- /form .needs-validation -->
                    </div><!-- /.card-body -->
                </div><!-- /.card -->

            </div><!-- /.page-section -->
        </div><!-- /.page-inner -->
    </div><!-- /.page -->
@endsection

@push('styles')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endpush

@push('scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript">
        $(function() {
            $("#ndis_dob").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
        // document.getElementById("notes").value = document.getElementById("notes").placeholder;
    </script>
@endpush
