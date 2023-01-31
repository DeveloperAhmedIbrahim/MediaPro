@extends('user.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Container-fluid starts -->
    <!-- Main content starts -->
    <div class="container-fluid mb-5">
        <div class="row">
            <div class="main-header">
                <h4>Select Video</h4>
            </div>
        </div>
    </div>
</div>
<div class="container text-center">
    <div class="row" >
    <div class="col-lg-12 mt-5">
							<div class="card">
								<div class="card-header">
                                    <div class="container">
                                <a class="btn btn-primary btn-sm"  href="{{ route('websites.create') }}">Add Video</a>
                                </div>
                                    <!-- <input type="button" class="btn btn-primary" value="Add Video" style="display:flex" href="{{url('/create-website')}}">
                                -->
									<h4 class="card-title mb-0">Website</h4>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table mb-0">
											<thead>
												<tr>
													
													<th>TITLE</th>
													<th>Chanels</th>
													<th>CUSTOM DOMAIN</th>
                                                    <th>ACTION</th>
												</tr>
											</thead>
											<tbody>
											@foreach($website as $websites)	
                                            <tr>
												<td>{{$websites->id}}</td>
													<td>{{$websites->title}}</td>
													<td>{{$websites->custom_domain}}</td>
													<td>
													<a href="{{ url('/delete/website/' . $websites->id) }}" type="button"  class="btn btn-primary">Show</a>

													<button type="submit" class="btn btn-success">Edit</button>
										
                    <a href="{{ url('/delete/website/' . $websites->id) }}" type="button" class="btn btn-danger">Delete</a>
								
                        </td>								
									</tr>
					@endforeach						
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
    
</div>
</div>

</div>
@endsection