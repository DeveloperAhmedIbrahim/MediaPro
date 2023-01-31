@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Container-fluid starts -->
    <!-- Main content starts -->
    <div class="container-fluid mb-5">
       <div class="row">
          <div class="main-header">
             <h4>Channels</h4>
          </div>
       </div>
    </div>
</div>
   <div class="container text-center" style="padding:20px; color:#e5e5e5">
      <p class="text-center ng-binding" style="font-size:24px; margin: 0 0 30px 50px;">Hi! Your channels list looks empty.  Create your first channel now.<p>
      <a href="{{url('/select_channel')}}" class="btn btn-primary text-center">Create Channels</a>
   </div>
</div>
@endsection