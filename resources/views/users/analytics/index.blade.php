@extends('user.layouts.app')
@section('content')

				<!-- Page Content -->
            <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header mt-5">
               <div class="row">
                  <div class="col-sm-12">
                     <h3 class="page-title">Player Analytics</h3>
                     <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard</li>
                     </ul>
                  </div>
               </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
               <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                  <div class="card dash-widget">
                     <div class="card-body">
                        <span class="dash-widget-icon"></span>
                        <div class="dash-widget-info">
                           <h3>0</h3>
                           <span>Today</span>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                  <div class="card dash-widget">
                     <div class="card-body">
                        <span class="dash-widget-icon"></span>
                        <div class="dash-widget-info">
                           <h3>0</h3>
                           <span>Last 7 days</span>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                  <div class="card dash-widget">
                     <div class="card-body">
                        <span class="dash-widget-icon"></span>
                        <div class="dash-widget-info">
                           <h3>0</h3>
                           <span>Last 30 days</span>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                  <div class="card dash-widget">
                     <div class="card-body">
                        <span class="dash-widget-icon"></span>
                        <div class="dash-widget-info">
                           <h3>0</h3>
                           <span>Total</span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-md-12">
                  <div class="row ml-2">
                 <h5>Channel plays:</h5>
                  </div>
                  <div class="row">
                  <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                  <div class="card dash-widget">
                     <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-eye" aria-hidden="true"></i></span>
                        <div class="dash-widget-info">
                           <h3>0</h3>
                           <span>loop</span>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                  <div class="card dash-widget">
                     <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-eye" aria-hidden="true"></i></span>
                        <div class="dash-widget-info">
                           <h3>0</h3>
                           <span>On Demand</span>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                  <div class="card dash-widget">
                     <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-eye" aria-hidden="true"></i></span>
                        <div class="dash-widget-info">
                           <h3>0</h3>
                           <span>Shedule</span>
                        </div>
                     </div>
                  </div>
               </div>

               </div>
               <div class="row">
               <div class="col-md-12">
                  <div class="row">

                     <div class="col-md-6 text-center" style="display:none">
                        <div class="card">
                           <div class="card-body">
                              <h3 class="card-title">Total Revenue</h3>
                              <div id="bar-charts"></div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6 text-center">
                        <div class="card">
                           <div class="card-body">
                              <h3 class="card-title">Sales Overview</h3>
                              <div id="line-charts"></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            </div>
            </div>




         </div>
         <!-- /Page Content -->
@endsection
