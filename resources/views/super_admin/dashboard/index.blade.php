@extends('layouts.admin-layout')
@section('title','Dashboard')
@section('content')
Dashboard------
<h1> {{ Auth::user()->name }}</h1>
@endsection
    