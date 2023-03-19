<?php
use App\Repositories\CommonRepository;
?>
@extends('admin.layouts.app')
@section('title', 'Edit Order Item')
@section('content')
    <!-- .page -->
    <div class="page has-sidebar has-sidebar-expand-xl">
        <!-- .page-inner -->
        <div class="page-inner">
            <!-- .page-title-bar -->
            <header class="page-title-bar">
                <h1 class="page-title"> Edit Order Item Information</h1>
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
                        <form id="editOrderItems" action="{{ route('editOrderItems') }}" method="POST">
                            <input type="hidden" name="id" value="{{ $orderItem->id }}">
                            <input type="hidden" name="order_number" value="{{ $orderItem->order_id }}">

                            <!-- .form-row -->
                            <div class="form-row">
                                <!-- form grid -->
                                <div class="col-md-12 mb-3">
                                    <label for="item_name">Item Name</label> <input type="text" class="form-control"
                                        id="item_name" name="item_name" value="{{ $orderItem->item_name }}" disabled>

                                </div><!-- /form grid -->
                                <div class="col-md-12 mb-3">
                                    <label for="item_quantity">Item Quantity</label> <input type="text"
                                        class="form-control" id="item_quantity" name="item_quantity"
                                        placeholder="please enter item_quantity" aria-describedby="inputLastName"
                                        required="" value="{{ $orderItem->item_quantity }}">

                                </div><!-- /form grid -->

                                <!-- form grid -->
                                <div class="col-md-12 mb-3">
                                    <label for="item_price">Item Price</label> <input type="text" class="form-control"
                                        id="item_price" name="item_price" aria-describedby="inputLastName" required=""
                                        value="{{ $orderItem->item_price }}">

                                </div><!-- /form grid -->
                                <div class="col-md-12 mb-3">
                                    <label for="product_category">Item Category</label> <input type="text"
                                        class="form-control" id="product_category" name="product_category"
                                        aria-describedby="inputLastName" value="{{ $orderItem->product_category }}">

                                </div><!-- /form grid -->

                            </div><!-- /.form-row -->
                            <!-- .form-actions -->
                            <div class="form-actions">
                                <a href="<?php echo url('admin/all_orders/view') . '/' . $orderItem->order_id; ?>">
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
