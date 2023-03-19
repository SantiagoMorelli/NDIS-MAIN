<?php
use App\Repositories\CommonRepository;
 ?>
@extends('admin.layouts.app')
@section('title','View Order')
@section('content')
	<!-- .page -->
    <div class="page has-sidebar has-sidebar-expand-xl">
      	<!-- .page-inner -->
       	<div class="page-inner" style="margin-right: 0 !important">
       		<!-- .page-title-bar -->
            <header class="page-title-bar">
              <!-- .breadcrumb -->
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item active">
                    @if($planManaged)
                      <a href="{{ route('getPlanManagedOrders') }}">
                    @else
                      <a href="{{ route('getOrders') }}">
                    @endif
                    <i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Back</a>
                  </li>
                </ol>
              </nav><!-- /.breadcrumb -->
                <h1 class="page-title"> View Order </h1>
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
                      <!-- .form-row -->
                      <legend><h5>Customer Details</h5></legend>
                      <div class="form-group">
                        <!-- form grid -->
                        <div class="col-md-12">
                          <label for="validationTooltipUsername"><b>First Name : </b></label> {{ CommonRepository::encrypt_decrypt($order->customer_first_name,'decrypt')  }}
                        </div><!-- /form grid -->

                        <!-- form grid -->
                        <div class="col-md-12">
                          <label for="validationTooltipUsername"><b>Last Name : </b></label> {{ CommonRepository::encrypt_decrypt($order->customer_last_name,'decrypt') }}
                        </div><!-- /form grid -->

                        <!-- form grid -->
                        <div class="col-md-12">
                          <label for="validationTooltipEmail"><b>Contact Phone Number :</b> </label> {{ CommonRepository::encrypt_decrypt($order->contact_phone_number,'decrypt') }}
                        </div><!-- /form grid -->

                        <!-- form grid -->
                        <div class="col-md-12">
                          <label for="validationTooltipEmail"><b>Billing Address : </b></label> {{ $order->billing_address_street }}@if($order->billing_address_street), @endif{{ $order->billing_address_city }}@if($order->billing_address_city), @endif{{ $order->billing_address_state }}@if($order->billing_address_state), @endif{{ $order->billing_address_post_code }}
                        </div><!-- /form grid -->

                         <!-- form grid -->
                        <div class="col-md-12">
                          <label for="validationTooltipEmail"><b>Shipping Address : </b></label> {{ $order->shipping_address_street }}@if($order->shipping_address_street), @endif{{ $order->shipping_address_city }}@if($order->shipping_address_city), @endif{{ $order->shipping_address_state }}@if($order->shipping_address_state), @endif{{ $order->shipping_address_post_code }}
                        </div><!-- /form grid -->
                      </div><!-- /.form-row -->
                  </div><!-- /.card-body -->

                  <!-- .card-body -->
                  <div class="card-body border-top">
                      <!-- .form-row -->
                      <legend><h5>NDIS Participant Details</h5></legend>
                      <div class="form-group">
                        <!-- form grid -->
                        <div class="col-md-12">
                          <label for="validationTooltipUsername"><b>NDIS Participant First Name : </b></label> {{ CommonRepository::encrypt_decrypt($order->ndis_participant_first_name,'decrypt')  }}
                        </div><!-- /form grid -->

                        <!-- form grid -->
                        <div class="col-md-12">
                          <label for="validationTooltipUsername"><b>NDIS Participant Last Name : </b></label> {{ CommonRepository::encrypt_decrypt($order->ndis_participant_last_name,'decrypt') }}
                        </div><!-- /form grid -->

                        <!-- form grid -->
                        <div class="col-md-12">
                          <label for="validationTooltipEmail"><b>NDIS Participant Number :</b> </label> {{ CommonRepository::encrypt_decrypt($order->ndis_participant_number,'decrypt') }}
                        </div><!-- /form grid -->

                        <!-- form grid -->
                        <div class="col-md-12">
                          <label for="validationTooltipEmail"><b>NDIS Participant Date of Birth : </b></label> {{ $order->ndis_participant_date_of_birth }}
                        </div><!-- /form grid -->
                      </div><!-- /.form-row -->
                  </div><!-- /.card-body -->

                  <!-- .card-body -->
                  <div class="card-body border-top">
                      <!-- .form-row -->
                      <legend><h5>NDIS Plan Details</h5></legend>
                      <div class="form-group">
                        <!-- form grid -->
                        <div class="col-md-12">
                          <label for="validationTooltipUsername"><b>Plan Management Option : </b></label> {{ CommonRepository::encrypt_decrypt($order->ndis_plan_management_option,'decrypt')  }}
                        </div><!-- /form grid -->

                        <!-- form grid -->
                        <div class="col-md-12">
                          <label for="validationTooltipUsername"><b>Plan Start Date : </b></label> {{ $order->ndis_plan_start_date }}
                        </div><!-- /form grid -->

                        <!-- form grid -->
                        <div class="col-md-12">
                          <label for="validationTooltipEmail"><b>Plan End Date :</b> </label> {{ $order->ndis_plan_end_date }}
                        </div><!-- /form grid -->

                        <!-- form grid -->
                        <div class="col-md-12">
                          <label for="validationTooltipEmail"><b>Plan Manager Name : </b></label> {{ CommonRepository::encrypt_decrypt($order->plan_manager_name,'decrypt')  }}
                        </div><!-- /form grid -->
                      </div><!-- /.form-row -->
                  </div><!-- /.card-body -->

                  <!-- .card-body -->
                  <div class="card-body border-top">
                      <!-- .form-row -->
                      <legend><h5>Parent Carer Details</h5></legend>
                      <div class="form-group">
                        <!-- form grid -->
                        <div class="col-md-12">
                          <label for="validationTooltipUsername"><b>Parent Carer Status : </b></label> {{ $order->parent_carer_status }}
                        </div><!-- /form grid -->

                        <!-- form grid -->
                        <div class="col-md-12">
                          <label for="validationTooltipUsername"><b>Parent Carer Name : </b></label> {{ CommonRepository::encrypt_decrypt($order->parent_carer_name,'decrypt') }}
                        </div><!-- /form grid -->

                        <!-- form grid -->
                        <div class="col-md-12">
                          <label for="validationTooltipEmail"><b>Parent Carer Email :</b> </label> {{ CommonRepository::encrypt_decrypt($order->parent_carer_email,'decrypt') }}
                        </div><!-- /form grid -->

                        <!-- form grid -->
                        <div class="col-md-12">
                          <label for="validationTooltipEmail"><b>Parent Carer Phone : </b></label> {{ CommonRepository::encrypt_decrypt($order->parent_carer_phone,'decrypt') }}
                        </div><!-- /form grid -->

                        <!-- form grid -->
                        <div class="col-md-12">
                          <label for="validationTooltipEmail"><b>Parent Carer Relationship : </b></label> {{ CommonRepository::encrypt_decrypt($order->parent_carer_relationship,'decrypt') }}
                        </div><!-- /form grid -->

                      </div><!-- /.form-row -->
                  </div><!-- /.card-body -->

                  <!-- .card-body -->
                  <div class="card-body border-top">
                      <!-- .form-row -->
                      <legend><h5>Order Details</h5></legend>
                      <div class="form-group">
                        <!-- form grid -->
                        <div class="col-md-12">
                          <label><b>Order Total : </b></label> {{ $order->order_total }}
                        </div><!-- /form grid -->

                        <!-- form grid -->
                        <div class="col-md-12">
                          <label><b>Shipping Total :</b> </label> {{ $order->shipping_total }}
                        </div><!-- /form grid -->

                        <!-- form grid -->
                        <div class="col-md-12">
                          <label><b>Gst Total : </b></label> {{ $order->gst_total }}
                        </div><!-- /form grid -->

                      </div><!-- /.form-row -->
                  </div><!-- /.card-body -->

                  <!-- .card-body -->
                  <div class="card-body border-top">
                    <legend><h5>Order Items</h5></legend>
                    @if($planManaged)
                      <!-- .table -->
                      <table id="itemlist-datatable" class="table dt-responsive nowrap w-100">
                        <thead>
                          <tr>
                            <th> Order No. </th>
                            <th> Item Name </th>
                            <th> Quantity </th>
                            <th> Price </th>
                          </tr>
                        </thead>
                      </table><!-- /.table -->
                    @else
                      <!-- .table -->
                      <table id="itemlist-datatable" class="table dt-responsive nowrap w-100">
                        <thead>
                          <tr>
                            <th> Order No. </th>
                            <th> Item Name </th>
                            <th> Quantity </th>
                            <th> Price </th>
                            <th> Claim Number </th>
                            <th> Product Category Item </th>
                            <th> Status </th>
                            <th> Action </th>
                          </tr>
                        </thead>
                      </table><!-- /.table -->
                    @endif
                    
                  </div><!-- /.card-body -->

                </div><!-- /.card -->

            </div><!-- /.page-section -->
       	</div><!-- /.page-inner -->
    </div><!-- /.page -->	
@endsection

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/javascript/pages/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('assets/javascript/pages/datatables-responsive-demo.js') }}"></script>
<script type="text/javascript">
  var plan_option = "{{ $planManaged }}";
  if (plan_option) {
    var table = $('#itemlist-datatable').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ url('admin/order_items') }}/{{ $orderId }}",
      responsive: true,
      dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>\n        <'table-responsive'tr>\n        <'row align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 d-flex justify-content-end'p>>",
      language: {
        paginate: {
          previous: '<i class="fa fa-lg fa-angle-left"></i>',
          next: '<i class="fa fa-lg fa-angle-right"></i>'
        }
      },
      columns: [
      { data: 'order_number'  },
      { data: 'item_name' },
      { data: 'item_quantity' },
      { data: 'item_price' },
      ],
      order: [[0, 'desc']]
    });
  } else {
    var table = $('#itemlist-datatable').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ url('admin/order_items') }}/{{ $orderId }}",
      responsive: true,
      dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>\n        <'table-responsive'tr>\n        <'row align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 d-flex justify-content-end'p>>",
      language: {
        paginate: {
          previous: '<i class="fa fa-lg fa-angle-left"></i>',
          next: '<i class="fa fa-lg fa-angle-right"></i>'
        }
      },
      columns: [
      { data: 'order_number'  },
      { data: 'item_name' },
      { data: 'item_quantity' },
      { data: 'item_price' },
      { data: 'claim_number' },
      { data: 'product_category_item' },
      { data: 'status', orderable: false },
      { data: 'action', orderable: false },
      ],
      order: [[0, 'desc']]
    });
  }
  

</script>
@endpush