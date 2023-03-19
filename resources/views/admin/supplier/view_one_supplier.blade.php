@extends('admin.layouts.app')
@section('title', 'Supplier Details')
@section('content')
    <div class="card-body border-top bg-white h-screen">
        <!-- .form-row -->
        <legend>
            <h5>Supplier Information</h5>
        </legend>
        <div class="form-group">
            <!-- form grid -->

            <div class="col-md-12">
                <label><b>Name : </b></label>
                {{ $supplier->supplier_name }}
            </div><!-- /form grid -->

            <!-- form grid -->
            <div class="col-md-12">
                <label><b>Contact :</b> </label> {{ $supplier->contact_person }}
            </div><!-- /form grid -->

            <!-- form grid -->
            <div class="col-md-12">
                <label><b>Email : </b></label> {{ $supplier->supplier_emailid }}
            </div>

            <!-- /form grid -->
            <div class="col-md-12">
                <label><b>Phone Number : </b></label> {{ $supplier->phone_number }}
            </div><!-- /form grid -->

            <!-- /form grid -->
            <div class="col-md-12">
                <label><b>Note : </b></label> {{ $supplier->note }}
            </div><!-- /form grid -->




        </div><!-- /.form-row -->
    </div><!-- /.card-body -->
@endsection
