@extends('admin.layouts.app')
@section('title', 'email customer')
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

                            <a href="{{ route('fetchAllOrders') }}">

                                <i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Back</a>
                        </li>
                    </ol>
                </nav><!-- /.breadcrumb -->
                <h1 class="page-title"> send email </h1>


                <x-authenticate-result />




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
                    <form id='emailCustomerForm'>

                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="emailFrom" class="form-label">send from</label>
                                <input class="form-control" id="emailSubject" required></input>
                            </div>

                            <div class="mb-3">
                                <label for="emailSubject" class="form-label">Subjects</label>
                                <input class="form-control" id="emailSubject" required></input>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button id='closeEmailCustomerButton' type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">
                                Cancel</button>
                            <button id='submitEmailCustomerButton' type="submit" class="btn btn-primary">Send</button>
                        </div>

                    </form>

                </div><!-- /.card -->

            </div><!-- /.page-section -->
        </div><!-- /.page-inner -->
    </div><!-- /.page -->
@endsection
