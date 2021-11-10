@extends('layouts.admin-layout')
@section('title','Dashboard')
@section('content')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('users.user')}}">List</a></li>
                        <li class="breadcrumb-item active">Edit User</li>
                    </ol>
                </div>
                <h4 class="page-title">Users</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <h4 class="header-title">Edit User</h4>
                <p class="sub-header">
                    <!-- <div class="form-group pull-right">
                        <div class="col-xs-2 col-sm-2">
                                <a href="#" class="btn btn-primary btn-rounded waves-effect waves-light">Add Class</a>
                        </div>
                    </div> -->
                </p>

                <div class="row">
                    <div class="col-lg-6">
                        <form id="userAddForm" method="post" action="{{ route('users.add_role_user') }}" autocomplete="off">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="teacher_id">Assign Role</label>
                                <select class="form-control" id="role_name" name="role_name">
                                    <option value="">Choose Role</option>
                                    @if (count($roleDetails) > 1)
                                    @foreach ($roleDetails as $role)
                                    <option value="{{ $role->role_id }}">{{ $role->role_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <span class="text-danger error-text role_name_error"></span>
                            </div>
                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter name">
                                <span class="text-danger error-text name_error"></span>
                            </div>
                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Email">
                                <span class="text-danger error-text email_error"></span>

                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password" placeholder="Enter your password">
                                    <div class="input-group-append" data-password="false">
                                        <div class="input-group-text">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-danger error-text password_error"></span>

                            </div>
                            <div class="form-group mb-3">
                                <label for="citizenship">Citizenship</label>
                                <input type="text" id="citizenship" name="citizenship" class="form-control" placeholder="Citizenship">
                            </div>
                            <div class="form-group mb-3">
                                <label for="occupation">Occupation</label>
                                <input type="text" id="occupation" name="occupation" class="form-control" placeholder="Occupation">
                            </div>
                            <div class="form-group mb-3">
                                <label for="student_id">Student ID</label>
                                <input type="text" id="student_id" name="student_id" class="form-control" placeholder="Student ID">
                            </div>
                            <div class="form-group mb-3">
                                <label for="address">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="5" placeholder="Address"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="age">Age</label>
                                <input class="form-control" id="age" type="number" name="age" placeholder="Age">
                            </div>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                        </form>
                    </div> <!-- end col -->
                </div>
            </div> <!-- end card-box -->
        </div> <!-- end col -->
    </div>
    <!--- end row -->
</div>
<!-- container -->
@endsection
