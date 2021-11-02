@extends('layouts.admin-layout')
@section('title','Settings')
@section('content')
Settings------
<h1> {{ Auth::user()->name }}</h1>
@endsection
