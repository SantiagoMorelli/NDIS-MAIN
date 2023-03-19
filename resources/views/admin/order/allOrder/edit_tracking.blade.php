<?php
use App\Repositories\CommonRepository;
?>
@extends('admin.layouts.app')
@section('title', 'Edit Tracking')
@section('content')
    <!-- .page -->
    <div class="page has-sidebar has-sidebar-expand-xl">
        <!-- .page-inner -->
        <div class="page-inner">
            <!-- .page-title-bar -->
            <header class="page-title-bar">
                <h1 class="page-title"> Edit Tracking Information</h1>
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
                        @if (session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                <button data-dismiss="alert" class="close close-sm" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        @if (session()->has('error'))
                            <div class="alert alert-danger" role="alert">
                                <button data-dismiss="alert" class="close close-sm" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                                {{ session()->get('error') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                        <!-- /succes - error messages -->
                        <!-- form .needs-validation -->
                        <form id="editOrderTracking" novalidate="" action="{{ route('editOrderTracking') }}"
                            method="POST">
                            <input type="hidden" name="id" value="{{ $orderTracking->id }}">
                            <input type="hidden" name="order_number" value="{{ $orderTracking->order_number }}">

                            <!-- .form-row -->
                            <div class="form-row">
                                <!-- form grid -->
                                <div class="col-md-12 mb-3">
                                    <label for="courier_company">Courier Company</label> <input type="text"
                                        class="form-control" id="courier_company" name="courier_company"
                                        placeholder="Courier Company Name" aria-describedby="inputFirstName" required=""
                                        value="{{ $orderTracking->courier_company }}">
                                    <div id="inputFirstName" class="invalid-feedback"> Please enter a Courier Company.
                                    </div>
                                </div><!-- /form grid -->
                                <div class="col-md-12 mb-3">
                                    <label for="tracking_number">Tracking Id</label> <input type="text"
                                        class="form-control" id="tracking_number" name="tracking_number"
                                        placeholder="please enter Tracking Id" aria-describedby="inputLastName"
                                        required="" value="{{ $orderTracking->tracking_number }}">
                                    <div id="inputLastName" class="invalid-feedback"> Please enter tracking id.
                                    </div>
                                </div><!-- /form grid -->

                                <!-- form grid -->
                                <div class="col-md-12 mb-3">
                                    <label for="expected_time_of_arrival">Excepted Time Of Arrival</label> <input
                                        type="date" class="form-control" id="expected_time_of_arrival"
                                        name="expected_time_of_arrival" placeholder="please enter expected Time Of Arrival"
                                        aria-describedby="inputLastName" required=""
                                        value="{{ $orderTracking->expected_time_of_arrival }}">
                                    <div id="inputLastName" class="invalid-feedback"> Please enter expected time of arrival.
                                    </div>
                                </div><!-- /form grid -->

                                <div class="col-md-12 mb-3">
                                    <label for="dispatch_time">Dispatch Time</label> <input type="date"
                                        class="form-control" id="dispatch_time" name="dispatch_time"
                                        placeholder="please enter dispatch time" aria-describedby="inputLastName"
                                        required="" value="{{ $orderTracking->dispatch_time }}">
                                    <div id="inputLastName" class="invalid-feedback"> Please enter dispatch time.
                                    </div>
                                </div><!-- /form grid -->

                                <div class="col-md-12 mb-3">
                                    <label for="item_name">item Name</label> <input type="text" class="form-control"
                                        id="item_name" name="item_name" placeholder="please enter supplier id"
                                        aria-describedby="inputLastName" required=""
                                        value="{{ $orderTracking->item_name }}">
                                    <div id="inputLastName" class="invalid-feedback"> Please enter item name.
                                    </div>
                                </div><!-- /form grid -->

                                <div class="col-md-12 mb-3">
                                    <label for="supplier_id">Supplier Id</label> <input type="text" class="form-control"
                                        id="supplier_id" name="supplier_id" placeholder="please enter supplier id"
                                        aria-describedby="inputLastName" required=""
                                        value="{{ $orderTracking->supplier_id }}">
                                    <div id="inputLastName" class="invalid-feedback"> Please enter supplier id.
                                    </div>
                                </div><!-- /form grid -->
                                <div class="col-md-12 mb-3">
                                    <label for="product_sku">Product Sku</label> <input type="text"
                                        class="form-control" id="product_sku" name="product_sku"
                                        placeholder="please enter product sku" aria-describedby="inputLastName"
                                        required="" value="{{ $orderTracking->product_sku }}">
                                    <div id="inputLastName" class="invalid-feedback"> Please enter product sku.
                                    </div>
                                </div><!-- /form grid -->

                                <div class="col-md-12 mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control" name="notes" id="notes" rows="2"
                                        placeholder="{{ $orderTracking->notes }}" form="editOrderTracking"></textarea>
                                </div>

                            </div><!-- /.form-row -->
                            <!-- .form-actions -->
                            <div class="form-actions">
                                <a href="<?php echo url('admin/all_orders/view') . '/' . $orderTracking->order_number; ?>">
                                    <button class="btn btn-secondary shadow-sm btn--sm mr-2"
                                        type="button">Cancel</button>
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
        document.getElementById("notes").value = document.getElementById("notes").placeholder;
    </script>
@endpush
