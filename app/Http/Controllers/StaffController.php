<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffController extends Controller
{
    //
    function index(){
        return view('staff.dashboard.index');
    }
}
