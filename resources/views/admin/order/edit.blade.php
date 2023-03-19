<?php
use App\Repositories\CommonRepository;
 ?>
@extends('admin.layouts.app')
@section('title','Edit Order')
@section('content')
	<!-- .page -->
    <div class="page has-sidebar has-sidebar-expand-xl">
      	<!-- .page-inner -->
       	<div class="page-inner">
       		<!-- .page-title-bar -->
            <header class="page-title-bar">
                <h1 class="page-title"> Edit Order </h1>
            </header><!-- /.page-title-bar -->
            <!-- .page-section -->
            <div class="page-section">
            	<div class="d-xl-none">
                  <button class="btn btn-danger btn-floated" type="button" data-toggle="sidebar"><i class="fa fa-th-list"></i></button>
                </div>
                <!-- .card -->
                <div class="card">
                  <!-- .card-body -->
                  <div class="card-body">
                    <!-- succes - error messages -->
                    @if(session()->has('success'))
                        <div class="alert alert-success" role="alert">
                          <button data-dismiss="alert" class="close close-sm" type="button">
                                            <i class="fa fa-times"></i>
                          </button>
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-danger" role="alert">
                          <button data-dismiss="alert" class="close close-sm" type="button">
                                            <i class="fa fa-times"></i>
                          </button>
                            {{ session()->get('error') }}
                        </div>
                    @endif
                    @if($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger" role="alert">
                                 {{ $error }}
                            </div>
                        @endforeach
                    @endif
                    <!-- /succes - error messages -->
                    <!-- form .needs-validation -->
                    <form class="" id="editOrderForm"  novalidate="" action="{{ route('editOrder') }}" method="POST">
                      <input type="hidden" name="id" value="{{ $order->id }}">
                      <!-- .form-row -->
                      <div class="form-row">
                        <!-- form grid -->
                        <div class="col-md-12 mb-3">
                          <label for="validationFirstname">NDIS Participant First Name</label> <input type="text" class="form-control" id="validationFirstname" name="ndis_participant_first_name" placeholder="Participant First Name" aria-describedby="inputFirstName" required="" value="{{ CommonRepository::encrypt_decrypt($order->ndis_participant_first_name,'decrypt')  }}">
                          <div id="inputFirstName" class="invalid-feedback"> Please enter a participant firstname. </div>
                        </div><!-- /form grid -->

                        <!-- form grid -->
                        <div class="col-md-12 mb-3">
                          <label for="validationLastname">NDIS Participant Last Name</label> <input type="text" class="form-control" id="validationLastname" name="ndis_participant_last_name" placeholder="Participant Last Name" aria-describedby="inputLastName" required="" value="{{ CommonRepository::encrypt_decrypt($order->ndis_participant_last_name,'decrypt') }}">
                          <div id="inputLastName" class="invalid-feedback"> Please enter a participant lastname. </div>
                        </div><!-- /form grid -->

                        <!-- form grid -->
                        <div class="col-md-12 mb-3">
                          <label for="validationNumber">NDIS Participant Number </label>
                          <input type="text" class="form-control" id="validationNumber" placeholder="Participant Number" name="ndis_participant_number" aria-describedby="inputNumber" required="" value="{{ CommonRepository::encrypt_decrypt($order->ndis_participant_number,'decrypt') }}">
                          <div id="inputNumber" class="invalid-feedback" > Please enter a participant Number. </div>
                        </div><!-- /form grid -->

                        <!-- form grid -->
                        <div class="col-md-12 mb-3">
                          <label for="ndis_dob">NDIS Participant Date of Birth </label>
                          <input type="text" class="form-control" id="ndis_dob" placeholder="Date of Birth" name="ndis_participant_date_of_birth" aria-describedby="inputDOB" required="" value="{{ $order->ndis_participant_date_of_birth }}">
                          <div id="inputDOB" class="invalid-feedback" > Please select a participant date of birth. </div>
                        </div><!-- /form grid -->

                    </div><!-- /.form-row -->
                      <!-- .form-actions -->
                      <div class="form-actions">
                        <a href="{{ route('getOrders') }}">
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
    $(function () {
        $("#ndis_dob").datepicker({dateFormat : 'yy-mm-dd'});
    });

    $(document).ready( function () {

  $('#editOrderForm').submit(function(e) {
      var count = 0;
      if ($.trim($("#validationFirstname").val()) == '') {
        $("#validationFirstname").addClass('is-invalid');
        $("#validationFirstname").removeClass('is-valid');
        count++;
      } else {
        $("#validationFirstname").removeClass('is-invalid');
        $("#validationFirstname").addClass('is-valid');
      }

      if ($.trim($("#validationLastname").val()) == '') {
        $("#validationLastname").addClass('is-invalid');
        $("#validationLastname").removeClass('is-valid');
        count++;
      } else {
        $("#validationLastname").removeClass('is-invalid');
        $("#validationLastname").addClass('is-valid');
      }

      if ($.trim($("#validationNumber").val()) == '') {
        $("#validationNumber").addClass('is-invalid');
        $("#validationNumber").removeClass('is-valid');
        count++;
      } else {
        $("#validationNumber").removeClass('is-invalid');
        $("#validationNumber").addClass('is-valid');
      }

      if ($.trim($("#ndis_dob").val()) == '') {
        $("#ndis_dob").addClass('is-invalid');
        $("#ndis_dob").removeClass('is-valid');
        count++;
      } else {
        $("#ndis_dob").removeClass('is-invalid');
        $("#ndis_dob").addClass('is-valid');
      }
      
      if (count > 0) {
        return false;
      }
    });
  });
</script>
@endpush