@extends('admin.layouts.app')
@section('title','Participant Plan Details')
@section('content')
<!-- .page -->
<div class="page">
  <!-- .page-inner -->
  <div class="page-inner">
    <!-- .page-title-bar -->
    <header class="page-title-bar">
      
      <!-- title -->
      <h1 class="page-title"> Participant Plan Details </h1>
           
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
                <th> Participant Plan Id </th>
                <th> Plan Start Date </th>
                <th> Plan End Date </th>
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
    ajax: "{{ route('planDetails') }}",
    responsive: true,
    dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>\n        <'table-responsive'tr>\n        <'row align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 d-flex justify-content-end'p>>",
    language: {
      paginate: {
        previous: '<i class="fa fa-lg fa-angle-left"></i>',
        next: '<i class="fa fa-lg fa-angle-right"></i>'
      }
    },
    columns: [
    { data: 'participant_plan_id', name: 'participant_plan_id' },
    { data: 'plan_start_date', name: 'plan_start_date' },
    { data: 'plan_end_date', name: 'plan_end_date' },
    ],
    order: [[0, 'desc']]
  });

</script>
@endpush