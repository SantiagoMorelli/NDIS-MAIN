<?php
use App\Repositories\CommonRepository;
$configOrderStatus = config('ndis.newOrderStatus1');
?>
@extends('admin.layouts.app')
@section('title', 'Edit ticket & task')
@section('content')
    <!-- .page -->
    <div class="page has-sidebar has-sidebar-expand-xl">
        <!-- .page-inner -->
        <div class="page-inner">
            <!-- .page-title-bar -->
            <header class="page-title-bar">
                <h1 class="page-title"> Edit Ticket & Task Information</h1>
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
                        <form id="editTicket" action="{{ route('editTicket', ['ticketId' => $ticketData->id]) }}"
                            method="POST">
                            <input type="hidden" name="id" value="{{ $ticketData->supplier_id }}">
                            {{-- <input type="hidden" name="order_number" value="{{ $ticketData->order_id }}"> --}}

                            <!-- .form-row -->

                            <div class="form-row">
                                <!-- form grid -->
                                <div class="col-md-12 mb-3">
                                    <label for="subject">Subject</label> <input type="text" class="form-control"
                                        id="subject" name="subject" value="{{ $ticketData->subject }}"
                                        {{ $ticketData->subject == 'progress check' ? 'disabled' : '' }}>

                                </div><!-- /form grid -->
                                @if (!empty($ticketData->order_number))

                                    <div class="col-md-12">
                                        <label><b>Order Number :</b> </label> {{ $ticketData->order_number }}
                                    </div><!-- /form grid -->

                                    <div class="col-md-12 mb-3 flex justify-start">

                                        <div>
                                            <label for="currentOrderStatus">Order Status</label>
                                            <br>
                                            @if ($orderStatus)
                                                <input type="text" class="form-control" id="currentOrderStatus"
                                                    name="currentOrderStatus" placeholder="please enter currentOrderStatus"
                                                    aria-describedby="inputLastName"
                                                    value="{{ $configOrderStatus[$orderStatus] }}" disabled
                                                    style="width: 9rem;"></input>
                                            @else
                                                <input type="text" class="form-control" id="currentOrderStatus"
                                                    name="currentOrderStatus" placeholder="please enter currentOrderStatus"
                                                    aria-describedby="inputLastName" value="Error" disabled
                                                    style="width: 9rem;"></input>
                                            @endif

                                        </div>
                                        <div class="pl-6 ">
                                            <label for="status">Change to</label>
                                            <br>
                                            <select type="text" class="form-control" id="orderStatus" name="orderStatus"
                                                placeholder="please enter orderStatus" aria-describedby="inputLastName"
                                                style="width: 9rem;">
                                                <option value="">Please select</option>
                                                @foreach ($configOrderStatus as $key => $value)
                                                    @if ($key != $orderStatus)
                                                        <option value={{ $key }}>{{ $value }}</option>
                                                    @endif
                                                @endforeach


                                            </select>
                                        </div>

                                    </div><!-- /form grid -->
                                @endif
                                <div class="col-md-12 mb-3 flex justify-start">
                                    <div>
                                        <label for="currentStatus">Current Status</label>
                                        <br>
                                        <input type="text" class="form-control" id="currentStatus" name="currentStatus"
                                            placeholder="please enter currentStatus" aria-describedby="inputLastName"
                                            value="{{ $ticketData->status }}" disabled style="width: 9rem;"></input>
                                    </div>
                                    <div class="pl-6 ">
                                        <label for="status">Change to</label>
                                        <br>
                                        <select type="text" class="form-control" id="status" name="status"
                                            placeholder="please enter status" aria-describedby="inputLastName"
                                            value="{{ $ticketData->status }}" style="width: 9rem;">
                                            <option value="">Please select</option>
                                            <option value="open">Open</option>
                                            <option value="processing">Processing</option>
                                            <option value="closed">Closed</option>

                                        </select>
                                    </div>

                                </div><!-- /form grid -->

                                <!-- form grid -->
                                <div class="col-md-12 mb-3 flex">
                                    <div>
                                        <label for="current_due_date">Current Due Date</label>
                                        <input type="text" class="form-control" id="current_due_date"
                                            name="current_due_date" aria-describedby="inputLastName"
                                            value="{{ $ticketData->due_date }}" disabled style="width: 9rem;"></input>
                                    </div>
                                    <div class="pl-6">
                                        <label for="due_date">Change to</label>
                                        <input type="date" class="form-control" id="due_date" name="due_date"
                                            aria-describedby="inputLastName" style="width: 9rem;"></input>
                                    </div>


                                </div><!-- /form grid -->
                                <div class="col-md-12 mb-3">
                                    <label for="notes">Notes</label>
                                    <textarea class="form-control" id="notes" name="notes" value="{{ $ticketData->notes }}">
                                    </textarea>

                                </div><!-- /form grid -->
                            </div><!-- /.form-row -->
                            <!-- .form-actions -->
                            <div class="form-actions">
                                <a href="{{ route('getTicketsPage') }}">
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
        // document.getElementById("notes").value = document.getElementById("notes").placeholder;
    </script>
@endpush
