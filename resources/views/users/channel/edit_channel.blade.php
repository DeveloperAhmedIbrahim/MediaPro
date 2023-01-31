@extends('user.layouts.app')
@section('content')
<!-- Page Content -->
<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Create Channel</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active">Create Channel</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Edit Duration</h4>
                </div>
                <div class="card-body">
                    <form action="{{url('/submit_linear')}}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label class="col-form-label col-md-2">Name</label>
                            <div class="col-md-10">
                                <input type="text" name="name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-12">Shedule Duration</label>

                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <select class="form-control" name="schedule_duration">
                                    <option>-- Action --</option>
                                    <option>Weekly</option>
                                    <option>Daily</option>
                                </select>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" readonly
                                    placeholder="You will schedule a whole week 24/7 and content will be repeated weekly.">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-md-12">Player Settings</label>

                        </div>
                        <div class="row">
                            <div class="col-md-5">


                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Player Setting</h4>
                                        <ul class="nav nav-tabs nav-tabs-solid nav-justified">
                                            <!-- <li class="nav-item"><a class="nav-link active" href="#solid-justified-tab1"
                                                    data-toggle="tab">Player Customization </a></li> -->
                                            <li class="nav-item"><a class="nav-link" href="#solid-justified-tab1"
                                                    data-toggle="tab">Privacy Settings </a></li>
                                            <li class="nav-item"><a class="nav-link" href="#solid-justified-tab2"
                                                    data-toggle="tab">Ads Monetization</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <!-- <div class="tab-pane show active" id="solid-justified-tab1">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group col-sm-12 col-md-6">

                                                            <label class="control-label ng-binding"
                                                                for="logo">Logo:</label>

                                                            <div class="custom-control custom-switch">

                                                                <input type="checkbox" class="custom-control-input" id="customSwitches" name="controllogo" value="1">
                                                                <label class="custom-control-label"
                                                                    for="customSwitches">Add Logo</label>
                                                            </div>

                                                            <div class="controls">
                                                                <div class="logoComponent">
                                                                    <div 
                                                                        style="cursor:pointer;position:relative;width:125px;height:125px;border:1px solid #eee;background-image: url('admin_assets/assets/img/transparent-background.png');"
                                                                        disabled="disabled">
                                                                        <img data-vl-image-preview="logo" class="thumb"
                                                                            alt=" " width="100%" onclick="document.getElementById('logo').click()"
                                                                            style="pointer-events: none;">
                                                                    </div>

                                                                    <div>
                                                                        <input id="logo" type="file" class="upload" name="logo"
                                                                            style="width:125px;height: 32px;background-color:">
                                                                        </btn>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group"
                                                            style="margin-left:10px;margin-right:10px;margin-bottom:10px">
                                                            <label for="exampleInputEmail1"
                                                                class="form-control-label">Upload Logo</label>
                                                            <input type="name" class="form-control"
                                                                id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                placeholder="Ad tag URL:">
                                                            <label for="exampleInputEmail1"
                                                                class="form-control-label mt-2">Logo position:</label>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-check">
                                                                    <label for="chkme" class="form-check-label">
                                                        <input type="checkbox" name="positionleft" class="form-check-input"
                                                            value="1" id="chkme">
                                                        Left</label>
                                                                    </div>

                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-check">
                                                                    <label for="chkme" class="form-check-label">
                                                        <input type="checkbox" name="positionright" class="form-check-input"
                                                            value="1" id="chkme">
                                                                Right</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div> -->
                                            <div class="tab-pane" id="solid-justified-tab1">
                                                <h6 style="margin-left:20px;margin-right:10px;margin-bottom:10px">
                                                    Where can this channel be embedded?
                                                </h6>
                                                <div class="form-check"
                                                    style="margin-left:20px;margin-right:10px;margin-bottom:10px">
                                                    <label for="chkme" class="form-check-label">
                                                        <input type="checkbox" name="anywhere" class="form-check-input"
                                                            value="1" id="chkme">
                                                        Anywhere ?
                                                    </label>
                                                </div>
                                                <div class="form-check"
                                                    style="margin-left:20px;margin-right:10px;margin-bottom:10px">
                                                    <label for="chkme" class="form-check-label">
                                                        <input type="checkbox" name="choose_domain"
                                                            class="form-check-input" id="chkme" value="1">
                                                        Only on domains I choose
                                                        <!-- <div class="row">
                                                            <div class="col-md-6">
                                                        <input type="name" class="form-control" name="adtagurl"
                                                        id="exampleInputEmail1" aria-describedby="emailHelp"
                                                        placeholder="mediapro.tv:">
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                             <button class="btn btn-primary btn-sm">submit</button>
</div>
                                                             </div> -->
                                                    </label>
                                                
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="solid-justified-tab2">
                                                <div class="form-group"
                                                    style="margin-left:10px;margin-right:10px;margin-bottom:10px">
                                                    <label for="exampleInputEmail1" class="form-control-label">Ad tag
                                                        URL:</label>
                                                    <input type="name" class="form-control" name="adtagurl"
                                                        id="exampleInputEmail1" aria-describedby="emailHelp"
                                                        placeholder="Ad tag URL:">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- @foreach ($videos as $video)
                            <div class="col-md-6">
                            @foreach (json_decode($video->image_url) as $val)
                            <video width="570" height="200" controls>
                <source src="{{ url('uploads/' . $val) }}" type="video/mp4">
                Your browser does not support the video tag.

            </video>
@endforeach
                            </div>
                            @endforeach -->
                        </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success waves-effect waves-light m-r-30">Submit</button>
        </div>

    </div>



    </form>
</div>
</div>

</div>
</div>
<!-- Row start -->
<!-- <div class="row" > -->
<!-- Form Control starts -->
<!-- <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header">
                           <h5 class="card-header-text">Scheduled (Linear)</h5>
                           <div class="f-right">
                              <a href="" data-toggle="modal" data-target="#input-type-Modal"><i class="icofont icofont-code-alt"></i></a>
                           </div>
                        </div>
                     -->
<!-- end of modal -->

<!-- <div class="card-block">
                           <form>
                              <div class="form-group">
                                 <label for="exampleInputEmail1" class="form-control-label">Name</label>
                                 <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Your Name" >
                               
                              </div>
                           
                              <div class="form-group">
                              <label for="exampleInputPassword1" class="form-control-label">Schedule Duration</label>
                                       <div class="input-group" id="dropdown1">
                                          <div class="input-group-btn">
                                            
                                          <button type="button" class="btn btn-danger shadow-none addon-btn waves-effect waves-light dropdown-toggle addon-btn" id="select" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Action
                                                        </button>
                                             <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#" id="option1" value="weekly">Weekly</a>
                                                <a class="dropdown-item" href="#" id="option2" value="daily">Daily</a>
                                           
                                                <div role="separator" class="dropdown-divider"></div>
                                        
                                             </div>
                                          </div>
                                          <input type="text" class="form-control" readonly placeholder="You will schedule a whole week 24/7 and content will be repeated weekly.">
                                       </div>
                              </div>
                              <div class="form-group">
                              <label for="exampleInputPassword1" class="form-control-label">Player settings:</label>
                            </div>
                            <div class="row">
                            <div class="col-md-4">
                            <div id="accordion">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        Player Customization  
        </button>
      </h5>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body">
        <div class="row"></div>
      <div class="input-group">
                                          <input type="text" id="iconaddon12" class="form-control" placeholder="Username">
                                          <span class="input-group-addon"><i class="icofont icofont-ui-user"></i></span>
                                       </div>
        <p style="margin-left:10px;margin-right:10px;margin-bottom:10px">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
         Privacy Settings  
        </button>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body" >
      <h6 style="margin-left:20px;margin-right:10px;margin-bottom:10px">
      Where can this channel be embedded?
</h6>
<div class="form-check" style="margin-left:20px;margin-right:10px;margin-bottom:10px">
                                 <label for="chkme" class="form-check-label">
                                            <input type="checkbox" class="form-check-input" id="chkme">
                                     Anywhere ?
                                        </label>
                              </div>
                              <div class="form-check" style="margin-left:20px;margin-right:10px;margin-bottom:10px">
                                 <label for="chkme" class="form-check-label">
                                            <input type="checkbox" class="form-check-input" id="chkme">
                                            Only on domains I choose 
                                        </label>
                              </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        Ads Monetization
        </button>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
      <div class="card-body">
      <div class="form-group" style="margin-left:10px;margin-right:10px;margin-bottom:10px">
                                 <label for="exampleInputEmail1" class="form-control-label">Ad tag URL:</label>
                                 <input type="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ad tag URL:" >
                               
                              </div>
     
      </div>
    </div>
  </div>
</div>
                            </div>    
                        <div class="col-md-6">
                        <video width="670" height="310" controls>
  <source src="movie.mp4" type="video/mp4">
  <source src="movie.ogg" type="video/ogg">
  Your browser does not support the video tag.
</video>
                        </div>    
                        </div>
                              <div class="form-group">
                              <button type="submit" class="btn btn-success waves-effect waves-light m-r-30">Submit</button>
                              </div>

                            
                            
                             
                              -->
<!-- </form> -->
<!-- </div>
                     </div>
                  </div> -->
<!-- Form Control ends -->


</div>
<!-- Row end -->


</div>
<!-- Main content ends -->
</div>

@endsection