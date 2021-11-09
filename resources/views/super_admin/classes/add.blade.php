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
                        <li class="breadcrumb-item"><a href="{{ route('super_admin.classes')}}">List</a></li>
                        <li class="breadcrumb-item active">Add Class</li>
                    </ol>
                </div>
                <h4 class="page-title">Classes</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <h4 class="header-title">Add New Class</h4>
                <p class="sub-header">
                    <!-- <div class="form-group pull-right">
                        <div class="col-xs-2 col-sm-2">
                                <a href="#" class="btn btn-primary btn-rounded waves-effect waves-light">Add Class</a>
                        </div>
                    </div> -->
                </p>

                <div class="row">
                    <div class="col-lg-6">
                        <form id="classesForm" method="post" action="{{ route('classes.add') }}" autocomplete="off">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="classes">Class Name</label>
                                <input type="text" id="classes" name="classes" class="form-control" placeholder="Enter class name">
                                <span class="text-danger error-text classes_error"></span>
                            </div>
                            <div class="form-group mb-3">
                                <label for="teacher_id">Assign Teacher</label>
                                <select class="form-control" id="teacher_id" name="teacher_id">
                                    <option value="">Choose teacher</option>
                                    @foreach ($teacherDetails as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text teacher_id_error"></span>
                            </div>
                            <button type="submit" id="classSubmit" class="btn btn-primary waves-effect waves-light">Submit</button>
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