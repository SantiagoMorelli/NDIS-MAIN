@extends('admin.layouts.app')
@section('title','Activate Device')
@section('content')
	<!-- .page -->
    <div class="page has-sidebar has-sidebar-expand-xl">
      	<!-- .page-inner -->
       	<div class="page-inner">
       		<!-- .page-title-bar -->
            <header class="page-title-bar">
                <h1 class="page-title"> Activate Device </h1>
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
                    <form class="needs-validation" id="createUserForm"  novalidate="" action="{{ route('postActivateDevice') }}" method="POST">
                      <!-- .form-row -->
                      <div class="form-row">
                        <!-- form grid -->
                        <div class="col-md-12 mb-3">
                          <label for="validationTooltipUsername">Activation Code</label> <input type="text" class="form-control" id="validationTooltipUsername" name="activation_code" placeholder="Activation Code" aria-describedby="inputGroupPrepend" required="">
                          <div id="inputGroupPrepend" class="invalid-feedback"> Please enter a activation code. </div>
                        </div><!-- /form grid -->
                      </div><!-- /.form-row -->
                      <div><b>Note.</b> Please do not try to activate device if device is already activated.</div>
                      <!-- .form-actions -->
                      <div class="form-actions">
                        <button class="btn btn-primary" type="submit">Activate Device</button>
                      </div><!-- /.form-actions -->
                    </form><!-- /form .needs-validation -->
                  </div><!-- /.card-body -->
                </div><!-- /.card -->

            </div><!-- /.page-section -->
       	</div><!-- /.page-inner -->
    </div><!-- /.page -->	
@endsection
