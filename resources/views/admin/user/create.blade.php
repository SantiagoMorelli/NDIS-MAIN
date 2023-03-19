@extends('admin.layouts.app')
@section('title','Create User')
@section('content')
	<!-- .page -->
    <div class="page has-sidebar has-sidebar-expand-xl">
      	<!-- .page-inner -->
       	<div class="page-inner">
       		<!-- .page-title-bar -->
            <header class="page-title-bar">
                <h1 class="page-title"> Create User </h1>
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
                    <form class="" id="createUserForm"  novalidate="" action="{{ url('admin/create_user') }}" method="POST">
                      <!-- .form-row -->
                      <div class="form-row">
                        <!-- form grid -->
                        <div class="col-md-12 mb-3">
                          <label for="validationTooltipUsername">Username</label> <input type="text" class="form-control" id="validationTooltipUsername" name="username" placeholder="Username" aria-describedby="inputGroupPrepend" required="">
                          <div id="inputGroupPrepend" class="invalid-feedback"> Please enter a username. </div>
                        </div><!-- /form grid -->

                        <!-- form grid -->
                        <div class="col-md-12 mb-3">
                          <label for="validationTooltipEmail">Email </label>
                          <input type="text" class="form-control" id="validationTooltipEmail" placeholder="Email" name="email" aria-describedby="inputGroupeEmail" required="">
                          <div id="inputGroupeEmail" class="invalid-feedback"> Please enter a valid email. </div>
                        </div><!-- /form grid -->
                    </div><!-- /.form-row -->
                      <!-- .form-group -->
                    <div class="form-group">
                        <label class="d-flex justify-content-between" for="validationTooltipPassword"><span>Password</span> <a href="#validationTooltipPassword" data-toggle="password"><i class="fa fa-eye fa-fw"></i> <span>Show</span></a></label>
                       <input type="password" name="password" class="form-control" value="" id="validationTooltipPassword" placeholder="Password" required="" aria-describedby="inputGroupePassword">
                       <div id="inputGroupePassword" class="invalid-feedback"> Password must be 8 character, one uppercase, one digit and one special character. </div>
                    </div><!-- /.form-group -->
                    <!-- .form-row -->
                      <div class="form-row">
                      	<!-- grid column -->
                        <div class="col-md-5 mb-3">
                          <label for="validationTooltipRole">Role</label> <select class="custom-select d-block w-100" name="role" id="validationTooltipRole" required="">
                            <option value=""> Choose... </option>
                            <option value="0">Staff Member</option>
                            <option value="1">Admin</option>
                          </select>
                          <div class="invalid-feedback"> Please select a valid role. </div>
                        </div><!-- /grid column -->
                      </div><!-- /.form-row -->
                      <!-- .form-actions -->
                      <div class="form-actions">
                        <a href="{{ route('listUser') }}">
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
@push('scripts')
<script type="text/javascript">

$(document).ready( function () {

  $('#createUserForm').submit(function(e) {
    var emailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    var count = 0;
    var password = $("#validationTooltipPassword").val();

    if ($.trim($("#validationTooltipUsername").val()) == '') {
      $("#validationTooltipUsername").addClass('is-invalid');
      $("#validationTooltipUsername").removeClass('is-valid');
      count++;
    } else {
      $("#validationTooltipUsername").removeClass('is-invalid');
      $("#validationTooltipUsername").addClass('is-valid');
    }

    if (!$("#validationTooltipEmail").val().match(emailformat)) {
      $("#validationTooltipEmail").addClass('is-invalid');
      $("#validationTooltipEmail").removeClass('is-valid');
      count++;
    } else {
      $("#validationTooltipEmail").removeClass('is-invalid');
      $("#validationTooltipEmail").addClass('is-valid');
    }

    if ($.trim(password) == '') {
      $("#validationTooltipPassword").addClass('is-invalid');
      $("#validationTooltipPassword").removeClass('is-valid');
      count++;
    } else {
      if (password.length > 7 && password.match(/[a-z]+/) && password.match(/[A-Z]+/) && password.match(/[0-9]+/) && password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
        $("#validationTooltipPassword").removeClass('is-invalid');
        $("#validationTooltipPassword").addClass('is-valid');
      } else {
        $("#validationTooltipPassword").addClass('is-invalid');
        $("#validationTooltipPassword").removeClass('is-valid');
        count++;
      }
    }

    if ($.trim($("#validationTooltipRole").val()) == '') {
      $("#validationTooltipRole").addClass('is-invalid');
      $("#validationTooltipRole").removeClass('is-valid');
      count++;
    } else {
      $("#validationTooltipRole").removeClass('is-invalid');
      $("#validationTooltipRole").addClass('is-valid');
    }

    if (count > 0) {
      return false;
    }

  });
});
</script>
@endpush