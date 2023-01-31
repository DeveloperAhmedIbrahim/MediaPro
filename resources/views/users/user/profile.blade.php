@extends('user.layouts.app')
@section('content')
<div class="content-wrapper mt-5">
    <!-- Container-fluid starts -->
    <!-- Main content starts -->
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="main-header  mt-5">
                <h3 class="text-center ml-2" > Profile</h3>
            </div>
        </div>
    </div>
</div>
<div class="container text-center mt-5">
    <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">{{Auth::user()->name}}</h4>
            </div>
            <div class="card mb-0">
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
									<div class="profile-view">
										<div class="profile-img-wrap">
											<div class="profile-img">
												<!-- <a href="#"><img alt="" src="assets/img/profiles/avatar-02.jpg"></a> -->
											</div>
										</div>
										<div class="profile-basic">
											<div class="row">
												<div class="col-md-5">
													<div class="profile-info-left">
                                                    <ul class="personal-info">
                                                    <li>
															<div class="title">Name</div>
															<div class="text">{{Auth::user()->name}}</div>
														</li>	
														<li>
															<div class="title">Email:</div>
															<div class="text"><a href="">{{Auth::user()->email}}</a></div>
														</li>
														<li>
															<div class="title">Birthday:</div>
															<div class="text">24th July</div>
														</li>
													
													</ul>														
													</div>
												</div>
										
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
        </div>
    
    </div>

    </div>
</div>

</div>
@endsection
