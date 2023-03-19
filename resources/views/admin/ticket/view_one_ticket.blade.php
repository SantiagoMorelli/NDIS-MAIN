@extends('admin.layouts.app')
@section('title', 'Ticket Details')
@section('content')
    <div class="card-body border-top bg-white h-screen">
        <!-- .form-row -->
        <legend>
            <h5>Ticket & Task Information</h5>
        </legend>
        <div class="form-group">
            <!-- form grid -->
            <div class="col-md-12">
                <label><b>Subject : </b></label>
                {{ $ticket->subject }}
            </div><!-- /form grid -->

            <!-- form grid -->
            <div class="col-md-12">
                <label><b>Ticket Status :</b> </label> {{ $ticket->status }}
            </div><!-- /form grid -->

            @if ($ticket->order_number)
                 <!-- form grid -->
                <div class="col-md-12">
                    <label><b>Order Number : </b> </label> <span class="pl-1 pr-3"> {{ $ticket->order_number }}</span>
                    <a href={{ route('viewOrderDetails', ['id' => $ticket->order_number]) }}><button
                            class="btn btn-xs btn-warning">View Order</button></a>
                </div><!-- /form grid -->
            @endif

            <!-- form grid -->
            <div class="col-md-12">
                <label><b>Notes : </b></label> {{ $ticket->notes }}
            </div>

            <!-- /form grid -->
            <div class="col-md-12">
                <label><b>Due Date : </b></label> {{ $ticket->due_date }}
            </div><!-- /form grid -->

            <!-- /form grid -->
            <div class="col-md-12">
                <label><b>Creation Time </b></label> {{ $ticket->created_at }}
            </div><!-- /form grid -->
            <div class="flex justify-start pt-3">
                <a href="{{ url()->previous() }}">
                    <button id='ticketCloseButton' type="button" class="btn btn-secondary btn-sm mr-5">
                        Back
                    </button>
                </a>

                <a class="text-white" href={{ route('editTicketPage', ['ticketId' => $ticket->id]) }}>
                    <button id='ticketSubmitButton' class="btn btn-success btn-sm mr-5">
                        Edit
                    </button>
                </a>

                <a href="{{ route('getTicketsPage') }}">
                    <button id='backTicketPage' type="button" class="btn btn-info btn-sm mr-5">
                        All Ticket Page
                    </button>
                </a>
            </div>



        </div><!-- /.form-row -->
    </div><!-- /.card-body -->
@endsection
