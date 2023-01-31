@extends('admin.layouts.app')
@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center mt-5">
                <div class="col">
                    <h3 class="page-title">Users</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_user"><i
                            class="fa fa-plus"></i> Add Users</a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div>
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row">
                            <div class="col-sm-12 col-md-4">
                                <div class="dataTables_length" id="DataTables_Table_0_length">
                                    <label> Show
                                        <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0"
                                            class="custom-select custom-select-sm form-control form-control-sm">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                        entries
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-8">
                                @if (Session::has('message_error'))
                                    <h3 class="text-danger">
                                        {{ session('message_error') }}
                                    </h3>
                                @endif
                                @if (Session::has('message_success'))
                                    <h3 class="text-success">
                                        {{ session('message_success') }}
                                    </h3>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped custom-table mb-0 datatable dataTable no-footer"
                                    id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr role="row">
                                            <th style="width: 30px;" class="sorting_asc" tabindex="0"
                                                aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                aria-sort="ascending" aria-label="#: activate to sort column descending">#
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Department Name: activate to sort column ascending"
                                                style="width: 540.797px;">Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Department Name: activate to sort column ascending"
                                                style="width: 540.797px;">Email</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Department Name: activate to sort column ascending"
                                                style="width: 540.797px;">Role</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Department Name: activate to sort column ascending"
                                                style="width: 540.797px;">Status</th>
                                            <th class="text-right sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1"
                                                aria-label="Action: activate to sort column ascending"
                                                style="width: 337.203px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($user as $users)
                                            <tr role="row" class="odd">
                                                <td class="sorting_1">{{ $users->id }}</td>
                                                <td>{{ $users->name }}</td>
                                                <td>{{ $users->email }}</td>
                                                <td>{{ $users->role }}</td>
                                                <td>
                                                    @if ($users->status == 'active')
                                                        <span style="color: #30F558">{{ $users->status }}</span>
                                                    @elseif ($users->status == 'inactive')
                                                        <span style="color: #F5C330">{{ $users->status }}</span>
                                                    @elseif ($users->status == 'cancelled')
                                                        <span style="color: #F55D30">{{ $users->status }}</span>
                                                    @else
                                                        <span style="color: darkgray">{{ $users->status }}</span>
                                                    @endif
                                                </td>
                                                {{-- <td>
                                                    <input data-id="{{ $users->id }}" class="toggle-class"
                                                        type="checkbox" data-onstyle="success" data-offstyle="danger"
                                                        data-toggle="toggle" data-on="Active" data-off="InActive"
                                                        {{ $users->status ? 'checked' : '' }}>
                                                </td> --}}
                                                <td class="text-right">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle"
                                                            data-toggle="dropdown" aria-expanded="false"><i
                                                                class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right"
                                                            x-placement="bottom-end"
                                                            style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(345px, 32px, 0px);">
                                                            <a class="dropdown-item"
                                                                onclick="GetUserByIDView({{ $users->id }})" href="#"
                                                                data-toggle="modal" data-target="#view_user_details"><i
                                                                class="fa fa-eye m-r-5"></i> View</a>

                                                            <a class="dropdown-item" href="#"
                                                                onclick="GetUserByIDEdit({{ $users->id }})"
                                                                data-toggle="modal" data-target="#edit_department"><i
                                                                class="fa fa-pencil m-r-5"></i> Edit</a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.delete_user', ['id' => $users->id]) }}"><i
                                                                class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <table >

                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info" id="DataTables_Table_0_info" role="status"
                                    aria-live="polite">Showing 1 to 6 of 6 entries</div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                    <ul class="pagination">
                                        <li class="paginate_button page-item previous disabled"
                                            id="DataTables_Table_0_previous"><a href="#"
                                                aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0"
                                                class="page-link">Previous</a></li>
                                        <li class="paginate_button page-item active"><a href="#"
                                                aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0"
                                                class="page-link">1</a></li>
                                        <li class="paginate_button page-item next disabled" id="DataTables_Table_0_next">
                                            <a href="#" aria-controls="DataTables_Table_0" data-dt-idx="2"
                                                tabindex="0" class="page-link">Next</a>
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
    <!-- View Users Modal -->
    <div id="view_user_details" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="view_user_id" name="id">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label">Name</label>
                                <input class="view_user_name form-control" type="text" name="name"
                                    style="pointer-events: none;">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label">Email</label>
                                <input class="view_user_email form-control" type="text" name="name"
                                    style="pointer-events: none;">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label">Role</label>
                                <input class="view_user_role form-control" type="text" name="name"
                                    style="pointer-events: none;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Users Modal -->
    <div id="edit_department" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container VideoContainer" id="VideoContainer">
                    </div>
                    <form action="{{ url('edit_user') }}" method="POST" id="edit_user_by_admin_form">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="user_id" class="edit_user_id">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                    <input class="form-control edit_user_name" type="text" name="user_name" required placeholder="Enter your Name">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                    <input class="form-control edit_user_email"  type="email" name="user_email" required placeholder="Enter your Email">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Password <span class="text-danger">*</span></label>
                                    <input class="form-control edit_user_password"  type="password" name="user_password" placeholder="Enter your Password">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Confirm Password <span class="text-danger">*</span></label>
                                    <input class="form-control edit_user_password_confirm"  type="password" name="user_password_confirm" placeholder="Enter your Password">
                                </div>
                                <span class="text-danger" id="edit_user_password_validation">Leave password field blank if you don't want change the password.</span>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">Role</label>
                                    <div class="col-md-10">
                                        <select class="form-control edit_user_role" name="user_role" required>
                                            <option value="0">-- Role --</option>
                                            <option value="admin">Admin</option>
                                            <option value="user">User</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">Status</label>
                                    <div class="col-md-10">
                                        <select class="form-control edit_user_status" name="user_status" required>
                                            <option value="0">-- Status --</option>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                            <option value="cancelled">Cancelled</option>
                                            <option value="blocked">Blocked</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                            </div>
                        </div>
                </div>
                <div class="submit-section" style="padding-bottom: 40px">
                    <button class="btn btn-primary submit-btn" id="SubmitEditUserByAdmin">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Add User Modal -->
    <div id="add_user" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container VideoContainer" id="VideoContainer">
                    </div>
                    <form action="{{ url('add_user') }}" method="POST" id="add_user_by_admin_form" onsubmit="ValidateAddUserByAdmin()">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                    <input class="form-control" id="user_name" type="text" name="user_name" required
                                        placeholder="Enter your Name">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                    <input class="form-control" id="user_email" type="email" name="user_email"
                                        required placeholder="Enter your Email">
                                        @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Password <span class="text-danger">*</span></label>
                                    <input class="form-control" id="user_password" type="password" name="user_password"
                                        required placeholder="Enter your Password">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-form-label">Confirm Password <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" id="user_password_confirm" type="password" required
                                        name="user_password" placeholder="Enter your Password">
                                </div>
                                <span class="text-danger" id="add_user_password_validation"></span>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">Role</label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="user_role" id="user_role" required>
                                            <option value="0">-- Role --</option>
                                            <option value="admin">Admin</option>
                                            <option value="user">User</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">Status</label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="user_status" id="user_status" required>
                                            <option value="0">-- Status --</option>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                            <option value="cancelled">Cancelled</option>
                                            <option value="blocked">Blocked</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                            </div>
                        </div>
                </div>
                <div class="submit-section" style="padding-bottom: 40px">
                    <button class="btn btn-primary submit-btn" id="SubmitAddUserByAdmin">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
