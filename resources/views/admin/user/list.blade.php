@extends('admin.layouts.app')
@section('title','List User')
@section('content')
<!-- .page -->
<div class="page">
  <!-- .page-inner -->
  <div class="page-inner">
    <!-- .page-title-bar -->
    <header class="page-title-bar">
      
      <!-- title -->
      <h1 class="page-title"> Users List  <a href="{{ route('getCreateUser') }}" style="float: right;">
        <button type="button" class="btn btn-success shadow-sm btn-sm mr-2" data-toggle="tooltip" data-placement="right">Create User</button>
      </a> </h1>
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
     
      </header><!-- /.page-title-bar -->
    <!-- .page-section -->
    <div class="page-section">
      <!-- .card -->
      <div class="card card-fluid">
        <!-- .card-body -->
        <div class="card-body">
          
          <!-- .table -->
          <table id="userlist-datatable" class="table dt-responsive nowrap w-100">
            <thead>
              <tr>
                <th> Name </th>
                <th> Email </th>
                <th> Role </th>
                <th> Action </th>
              </tr>
            </thead>
          </table><!-- /.table -->
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

  var table = $('#userlist-datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('listUser') }}",
    responsive: true,
    dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>\n        <'table-responsive'tr>\n        <'row align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 d-flex justify-content-end'p>>",
    language: {
      paginate: {
        previous: '<i class="fa fa-lg fa-angle-left"></i>',
        next: '<i class="fa fa-lg fa-angle-right"></i>'
      }
    },
    columns: [
    // { data: 'id', name: 'id' },
    { data: 'name', name: 'name' },
    { data: 'email', name: 'email' },
    { data: 'is_admin', name: 'is_admin' },
    {data: 'action', name: 'action', orderable: false},
    ],
    order: [[0, 'desc']]
  });

  function deleteFunc(id){
    if (confirm("Are you sure to remove this record?") == true) {
      var id = id;
      // ajax
      $.ajax({
        type:"POST",
        url: "{{ route('deleteUser') }}",
        data: { id: id },
        dataType: 'json',
        success: function(res){
          var oTable = $('#userlist-datatable').dataTable();
          oTable.fnDraw(false);
        }
      });
    }
  }

</script>
@endpush