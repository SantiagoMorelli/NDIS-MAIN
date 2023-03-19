<?php 
use App\Services\Common;
?>
@extends('admin.layouts.app')
@section('title','Configuration Device')
@section('content')
<!-- .page -->
<div class="page">
  <!-- .page-inner -->
  <div class="page-inner">
    <!-- .page-title-bar -->
    <header class="page-title-bar">
      
      <!-- title -->
      <h1 class="page-title">Configuration 
        <a href="{{ route('activateDevice') }}" style="float: right;">
          <button type="button" class="btn btn-success shadow-sm btn-sm mr-2" data-toggle="tooltip" data-placement="right" >Activate Device</button>
        </a> 
        <a href="{{ route('manuallyRefreshDevice') }}" style="float: right;">
          <button type="button" class="btn btn-primary shadow-sm btn-sm mr-2" data-toggle="tooltip" data-placement="right" onclick="refreshDevice()">Refresh Device</button>
        </a>
      </h1>
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
          <table id="device-datatable" class="table dt-responsive nowrap w-100">
            <thead>
              <tr>
                <th> Device Expiry </th>
                <th> Key Expiry </th>
                <th> Access Token Expiry </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                  @if(isset($deviceData['device_expiry']))
                  @php
                    $convertAustralianTime = Common::dateUTCToClientTZ('Y-m-d H:i:s',time(),false,'Australia/Sydney');
                    $currentDateTime = $convertAustralianTime->format('Y-m-d H:i:s');
                    $timestamp1 = strtotime($currentDateTime);

                    $deviceExpiryTime = strtotime($deviceData['device_expiry']);
                    $keyExpiryTime = strtotime($deviceData['key_expiry']);
                  @endphp
                <td>
                  @if($timestamp1 > $deviceExpiryTime)
                    <span class="badge badge-lg badge-danger">{{ $deviceData['device_expiry'] }}</span>
                  @else
                    {{ $deviceData['device_expiry'] }}
                  @endif
                </td>
                <td>
                  @if($timestamp1 > $keyExpiryTime)
                    <span class="badge badge-lg badge-danger">{{ $deviceData['key_expiry'] }}</span>
                  @else
                    {{ $deviceData['key_expiry'] }}
                  @endif
                </td>
                <td>
                  @if(time() > strtotime($deviceData['token_expiry']))
                    <span class="badge badge-lg badge-danger">{{ $deviceData['token_expiry'] }}</span>
                  @else
                    {{ $deviceData['token_expiry'] }}
                  @endif
                </td>
                @endif
              </tr>
            </tbody>
          </table><!-- /.table -->
        </div><!-- /.card-body -->
      </div><!-- /.card -->
    </div><!-- /.page-section -->
  </div><!-- /.page-inner -->
</div><!-- /.page -->
@endsection

{{-- @push('styles')
  <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}">
@endpush --}}

@push('scripts')
<script type="text/javascript">
  function refreshDevice() {
    $("#loadercontainer2").addClass("showloader");  
  }
</script>
{{-- <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/javascript/pages/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('assets/javascript/pages/datatables-responsive-demo.js') }}"></script>
<script type="text/javascript">

  var table = $('#device-datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('configuration') }}",
    responsive: true,
    dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>\n        <'table-responsive'tr>\n        <'row align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 d-flex justify-content-end'p>>",
    language: {
      paginate: {
        previous: '<i class="fa fa-lg fa-angle-left"></i>',
        next: '<i class="fa fa-lg fa-angle-right"></i>'
      }
    },
    columns: [
    { data: 'device_expiry', 
     render:function(data, type, row, meta){
      if (row.check_device_expiry == 1) {
        data = '<span class="badge badge-lg badge-danger">'+row.device_expiry+'</span>';
        return data;
      }
       return row.device_expiry;
      }},
    { data: 'key_expiry', 
     render:function(data, type, row, meta){
      if (row.check_key_expiry == 1) {
        data = '<span class="badge badge-lg badge-danger">'+row.key_expiry+'</span>';
        return data;
      }
       return row.key_expiry;
      }},
    { data: 'token_expiry', 
     render:function(data, type, row, meta){
      if (row.check_expiry == 1) {
        data = '<span class="badge badge-lg badge-danger">'+row.token_expiry+'</span>';
        return data;
      }
       return row.token_expiry;
      }
   },
    ],
    order: [[0, 'desc']]
  });

</script> --}}
@endpush