@extends('user.layouts.app')
@section('content')
<!-- Page Content -->
<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12 mt-5">
                <h3 class="page-title">Create Website</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active">Create Website</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Websites </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('websites.store') }}" method="POST">
                        @csrf
                    
                        <div class="form-group row">
                            <label class="col-form-label col-md-2">title</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="title">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-2">custom_domain</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="custom_domain">
                            </div>
                        </div>
                        <div class="form-group">
        <button type="submit" class="btn btn-success waves-effect waves-light m-r-30">Submit</button>
    </div>
                </div>
            </div>
        </div>

    </div>

    </form>
</div>
</div>

</div>
</div>
<!-- Row start -->
<!-- <div class="row" > -->


</div>
<!-- Row end -->


</div>
<!-- Main content ends -->
</div>

@endsection