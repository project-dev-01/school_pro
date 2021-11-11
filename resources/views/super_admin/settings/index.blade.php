@extends('layouts.admin-layout')
@section('title','Settings')
@section('content')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">UBold</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Extras</a></li> -->
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
                <h4 class="page-title">Profile</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-4 col-xl-4">
            <div class="card-box text-center">
                <img src="{{asset('users/images').'/'.Auth::user()->picture}}" class="rounded-circle avatar-lg img-thumbnail admin_picture" alt="profile-image">
                <!-- <img src="{{ asset('images/users/default.jpg') }}" class="rounded-circle avatar-lg img-thumbnail admin_picture" alt="profile-image"> -->
                <h4 class="mb-0 user_name">{{Auth::user()->name}}</h4>

                <div class="text-left mt-3">
                    <input type="file" name="admin_image" id="admin_image" style="opacity: 0;height:1px;display:none">
                    <a href="javascript:void(0)" class="btn btn-primary btn-block" id="change_picture_btn"><b>Change picture</b></a>
                </div>
                <!-- <p class="text-muted">@webdesigner</p> -->

                <div class="text-left mt-3">
                    <h4 class="font-13 text-uppercase">About Me :</h4>
                    <!-- <p class="text-muted font-13 mb-3">
                        Hi I'm Johnathn Deo,has been the industry's standard dummy text ever since the
                        1500s, when an unknown printer took a galley of type.
                    </p> -->
                    <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ml-2 user_name">{{Auth::user()->name}}</span></p>

                    <!-- <p class="text-muted mb-2 font-13"><strong>Mobile :</strong><span class="ml-2">(123)
                            123 1234</span></p> -->

                    <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ml-2 ">{{Auth::user()->email}}</span></p>

                    <!-- <p class="text-muted mb-1 font-13"><strong>Location :</strong> <span class="ml-2">USA</span></p> -->
                </div>
            </div> <!-- end card-box -->

        </div> <!-- end col-->

        <div class="col-lg-8 col-xl-8">
            <div class="card-box">
                <ul class="nav nav-pills navtab-bg nav-justified">
                    <li class="nav-item">
                        <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link active">
                            Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#changePassword" data-toggle="tab" aria-expanded="true" class="nav-link">
                            Change Password
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane show active" id="settings">
                        <form  method="POST" action="{{ route('updateProfileInfo') }}" id="updateProfileInfo">
                            <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Personal Info</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" placeholder="Enter name">
                                        <span class="text-danger error-text name_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email Address</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" placeholder="Enter email">
                                        <span class="text-danger error-text email_error"></span>
                                        <!-- <span class="form-text text-muted"><small>If you want to change email please <a href="javascript: void(0);">click</a> here.</small></span> -->
                                    </div>
                                </div>
                            </div> <!-- end row -->

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea class="form-control" id="address" rows="4" name="address" placeholder="Enter Address...">{{ Auth::user()->address }}</textarea>
                                        <span class="text-danger error-text address_error"></span>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->
                            <div class="text-right">
                                <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Update</button>
                            </div>
                        </form>
                    </div>
                    <!-- end settings content-->

                    <div class="tab-pane" id="changePassword">

                        <!-- comment box -->
                        <form action="{{ route('changePassword') }}" method="POST" id="changeNewPassword" class="comment-area-box mt-2 mb-3">
                        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Change Password</h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Old Passord</label>
                                        <input type="password" class="form-control" id="oldpassword" name="oldpassword" placeholder="Enter current password">
                                        <span class="text-danger error-text oldpassword_error"></span>
                                    </div>
                                </div>
                            </div> <!-- end row -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newpassword">New Password</label>
                                        <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="Enter new password">
                                        <span class="text-danger error-text newpassword_error"></span>
                                    </div>
                                </div>
                            </div> <!-- end row -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cnewpassword">Confirm New Password</label>
                                        <input type="password" class="form-control" id="cnewpassword" name="cnewpassword" placeholder="ReEnter new password">
                                        <span class="text-danger error-text cnewpassword_error"></span>
                                    </div>
                                </div>
                            </div> <!-- end row -->
                            <div class="text-right">
                                <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                            </div>
                        </form>
                        <!-- end comment box -->

                    </div>
                    <!-- end changePassword content-->



                </div> <!-- end tab-content -->
            </div> <!-- end card-box-->

        </div> <!-- end col -->
    </div>
    <!-- end row-->

</div> <!-- container -->@endsection