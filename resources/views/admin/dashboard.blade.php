@extends('admin.layouts.app')
@section('title','Dashboard')
@section('content')
<!-- .page -->
<div class="page">
	<!-- .page-inner -->
	<div class="page-inner">
	  <!-- .page-title-bar -->
	  	<header class="page-title-bar">
	  	</header><!-- /.page-title-bar -->
	  <!-- .page-section -->
	  <div class="page-section">
	    <!-- .section-block -->
	    <div class="section-block">
	      <!-- metric row -->
	      <div class="metric-row">
	        <div class="col-lg-9">
	          <div class="metric-row metric-flush">
	            <!-- metric column -->
	            <div class="col">
	              <!-- .metric -->
	              <a href="#" class="metric metric-bordered align-items-center">
	                <h2 class="metric-label"> Total Orders </h2>
	                <p class="metric-value h3">
	                  <span class="value">{{ $order['total_orders'] }}</span>
	                </p>
	              </a> <!-- /.metric -->
	            </div><!-- /metric column -->
	            <!-- metric column -->
	            <div class="col">
	              <!-- .metric -->
	              <a href="#" class="metric metric-bordered align-items-center">
	                <h2 class="metric-label"> Paid Orders </h2>
	                <p class="metric-value h3">
	                  <span class="value">{{ $order['paid_orders'] }}</span>
	                </p>
	              </a> <!-- /.metric -->
	            </div><!-- /metric column -->
	            <!-- metric column -->
	            <div class="col">
	              <!-- .metric -->
	              <a href="#" class="metric metric-bordered align-items-center">
	                <h2 class="metric-label"> Error Orders </h2>
	                <p class="metric-value h3">
	                  <span class="value">{{ $order['error_orders'] }}</span>
	                </p>
	              </a> <!-- /.metric -->
	            </div><!-- /metric column -->
	          </div>
	        </div><!-- metric column -->
	        <div class="col-lg-3">
	          <!-- .metric -->
	          <a href="#" class="metric metric-bordered">
	            <div class="metric-badge">
	              <span class="badge badge-lg badge-success"><span class="oi oi-media-record pulse mr-1"></span> Active Orders </span>
	            </div>
	            <p class="metric-value h3">
	              </sub> <span class="value">{{ $order['active_orders'] }}</span>
	            </p>
	          </a> <!-- /.metric -->
	        </div><!-- /metric column -->
	      </div><!-- /metric row -->
	    </div><!-- /.section-block -->
	  </div><!-- /.page-section -->
	</div><!-- /.page-inner -->
</div><!-- /.page -->
@endsection