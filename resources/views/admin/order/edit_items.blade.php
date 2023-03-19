<?php
use App\Repositories\CommonRepository;
 ?>
@extends('admin.layouts.app')
@section('title','Edit Order Item')
@section('content')
	<!-- .page -->
    <div class="page has-sidebar has-sidebar-expand-xl">
      	<!-- .page-inner -->
       	<div class="page-inner">
       		<!-- .page-title-bar -->
            <header class="page-title-bar">
                <h1 class="page-title"> Edit Order Item</h1>
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
                    <form class="" id="editOrderItemForm"  novalidate="" action="{{ route('editOrderItem') }}" method="POST">
                      <input type="hidden" name="id" value="{{ $orderItem->id }}">
                      <input type="hidden" name="orders_id" value="{{ $orderItem->orders_id }}">
                      <!-- .form-row -->
                      <div class="form-row">
                        <!-- form grid -->
                        <div class="col-md-12 mb-3">
                          <label for="validationCategory">Product Category</label> <input type="text" class="form-control" id="validationCategory" name="product_category" placeholder="Product Category" aria-describedby="inputFirstName" required="" value="{{ $orderItem->product_category  }}">
                          <div id="inputFirstName" class="invalid-feedback"> Please enter a product category. </div>
                        </div><!-- /form grid -->

                        <!-- form grid -->
                        <div class="col-md-12 mb-3">
                          <label for="validationItem">Product Category Item</label> <input type="text" class="form-control" id="validationItem" name="product_category_item" placeholder="Product Category Item" aria-describedby="inputLastName" required="" value="{{ $orderItem->product_category_item }}">
                          <div id="inputLastName" class="invalid-feedback"> Please enter a product category item. </div>
                        </div><!-- /form grid -->

                    </div><!-- /.form-row -->
                      <!-- .form-actions -->
                      <div class="form-actions">
                        <a href="<?php echo url('/admin/order/view').'/'.$orderItem->orders_id ?>">
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

  $('#editOrderItemForm').submit(function(e) {
      var count = 0;
      if ($.trim($("#validationCategory").val()) == '') {
        $("#validationCategory").addClass('is-invalid');
        $("#validationCategory").removeClass('is-valid');
        count++;
      } else {
        $("#validationCategory").removeClass('is-invalid');
        $("#validationCategory").addClass('is-valid');
      }

      if ($.trim($("#validationItem").val()) == '') {
        $("#validationItem").addClass('is-invalid');
        $("#validationItem").removeClass('is-valid');
        count++;
      } else {
        $("#validationItem").removeClass('is-invalid');
        $("#validationItem").addClass('is-valid');
      }

      if (count > 0) {
        return false;
      }
    });
  });
</script>
@endpush