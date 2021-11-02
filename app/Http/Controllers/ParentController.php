<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParentController extends Controller
{
    //
    function index(){
        return view('parent.dashboard.index');
    }
}
