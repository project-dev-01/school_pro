<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;

class SuperAdminController extends Controller
{
    //
    function index()
    {
        return view('super_admin.dashboard.index');
    }
    function settings()
    {
        return view('super_admin.settings.index');
    }
    function classes()
    {
        return view('super_admin.classes.index');
    }
    function addClasses()
    {
        $teacherDetails = User::select('id', 'name')->where('role_id', 3)->get();
        return view('super_admin.classes.add', ['teacherDetails' => $teacherDetails]);
    }
    //add New Class
    public function addClass(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'classes' => 'required|unique:classes',
            'teacher_id' => 'required',
        ]);

        if (!$validator->passes()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $class = new Classes();
            $class->classes = $request->classes;
            $class->teacher_id = $request->teacher_id;
            $query = $class->save();

            if (!$query) {
                return response()->json(['code' => 0, 'msg' => 'Something went wrong']);
            } else {
                return response()->json(['code' => 1, 'msg' => 'New Class has been successfully saved']);
            }
        }
    }
    // get class details
    public function getClassList(Request $request)
    {
        // $classes = Classes::all();
        $classes = Classes::join('users', 'classes.teacher_id', '=', 'users.id')
            ->get(['classes.classes', 'classes.class_id', 'classes.teacher_id', 'users.role_id', 'users.name']);
        return DataTables::of($classes)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                return '<div class="button-list">
                                <a href="' . route('classes.edit', $row['class_id']) . '" class="btn btn-blue waves-effect waves-light" data-id="' . $row['class_id'] . '">Update</a>
                                <a href="javascript:void(0)" class="btn btn-danger waves-effect waves-light" data-id="' . $row['class_id'] . '" id="deleteClassBtn">Delete</a>
                        </div>';
            })
            ->rawColumns(['actions', 'checkbox'])
            ->make(true);
    }
    //GET Class detail
    public function editClass(Request $request)
    {

        $teacherDetails = User::select('id', 'name')->where('role_id', 3)->get();
        $classID = $request->route('id');
        $editRow = Classes::where('class_id', $classID)->get();
        return view('super_admin.classes.edit', ['teacherDetails' => $teacherDetails, 'editClass' => $editRow]);
    }

    //UPDATE Class DETAILS
    public function updateClass(Request $request)
    {
        // dd($request);
        $classID = $request->class_id;

        $validator = \Validator::make($request->all(), [
            'classes' => 'required',
            'teacher_id' => 'required',
        ]);

        if (!$validator->passes()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {

            $query = Classes::where('class_id', $classID)
                ->update(['classes' => $request->classes, 'teacher_id' => $request->teacher_id]);
            if ($query) {
                return response()->json(['code' => 1, 'msg' => 'Class Details have Been updated']);
            } else {
                return response()->json(['code' => 0, 'msg' => 'Something went wrong']);
            }
        }
    }

    // DELETE Class Details
    public function deleteClass(Request $request)
    {
        $classID = $request->class_id;
        $query = Classes::where('class_id', $classID)->delete();

        if ($query) {
            return response()->json(['code' => 1, 'msg' => 'Class has been deleted from database']);
        } else {
            return response()->json(['code' => 0, 'msg' => 'Something went wrong']);
        }
    }
}
