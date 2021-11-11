<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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

    // update profile info
    function updateProfileInfo(Request $request){
        // dd($request->address);
 
        $validator = \Validator::make($request->all(),[
            'name'=>'required',
            'email'=> 'required|email|unique:users,email,'.Auth::user()->id,
            'address'=>'required',
        ]);
        if(!$validator->passes()){
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
             $query = User::find(Auth::user()->id)->update([
                  'name'=>$request->name,
                  'email'=>$request->email,
                  'address'=>$request->address,
             ]);

             if(!$query){
                 return response()->json(['status'=>0,'msg'=>'Something went wrong.']);
             }else{
                 return response()->json(['status'=>1,'msg'=>'Your profile info has been update successfuly.']);
             }
        }
    }

    // update profile picture
    function updatePicture(Request $request){
        
        $path = 'users/images/';
        $file = $request->file('admin_image');
        $new_name = 'UIMG_'.date('Ymd').uniqid().'.jpg';

        //Upload new image
        $upload = $file->move(public_path($path), $new_name);
        
        if( !$upload ){
            return response()->json(['status'=>0,'msg'=>'Something went wrong, upload new picture failed.']);
        }else{
            //Get Old picture
            $oldPicture = User::find(Auth::user()->id)->getAttributes()['picture'];

            if( $oldPicture != '' ){
                if( \File::exists(public_path($path.$oldPicture))){
                    \File::delete(public_path($path.$oldPicture));
                }
            }

            //Update DB
            $update = User::find(Auth::user()->id)->update(['picture'=>$new_name]);

            if( !$upload ){
                return response()->json(['status'=>0,'msg'=>'Something went wrong, updating picture in db failed.']);
            }else{
                return response()->json(['status'=>1,'msg'=>'Your profile picture has been updated successfully']);
            }
        }
    }

    // change password
    function changePassword(Request $request){
        //Validate form
        $validator = \Validator::make($request->all(),[
            'oldpassword'=>[
                'required', function($attribute, $value, $fail){
                    if( !\Hash::check($value, Auth::user()->password) ){
                        return $fail(__('The current password is incorrect'));
                    }
                },
                'min:8',
                'max:30'
             ],
             'newpassword'=>'required|min:8|max:30',
             'cnewpassword'=>'required|same:newpassword'
         ],[
             'oldpassword.required'=>'Enter your current password',
             'oldpassword.min'=>'Old password must have atleast 8 characters',
             'oldpassword.max'=>'Old password must not be greater than 30 characters',
             'newpassword.required'=>'Enter new password',
             'newpassword.min'=>'New password must have atleast 8 characters',
             'newpassword.max'=>'New password must not be greater than 30 characters',
             'cnewpassword.required'=>'ReEnter your new password',
             'cnewpassword.same'=>'New password and Confirm new password must match'
         ]);

        if( !$validator->passes() ){
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
             
         $update = User::find(Auth::user()->id)->update(['password'=>\Hash::make($request->newpassword)]);

         if( !$update ){
             return response()->json(['status'=>0,'msg'=>'Something went wrong, Failed to update password in db']);
         }else{
             return response()->json(['status'=>1,'msg'=>'Your password has been changed successfully']);
         }
        }
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
        // dd($teacherDetails);
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

    // users page
    function users()
    {
        return view('super_admin.users.index');
    }

    // get users details
    public function getUserList(Request $request)
    {
        // $users = User::all();
        // dd($users);
        $users = User::join('roles', 'users.role_id', '=', 'roles.role_id')
            ->where('users.role_id','!=',1)
            ->get(['users.id','users.name', 'users.role_id', 'roles.role_name', 'roles.role_slug']);
            // dd($users);
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                return '<div class="button-list">
                                <a href="javascript:void(0)" class="btn btn-danger waves-effect waves-light" data-id="' . $row['id'] . '" id="deleteUserBtn">Delete</a>
                        </div>';
            })
            // <a href="' . route('users.edit', $row['id']) . '" class="btn btn-blue waves-effect waves-light" data-id="' . $row['id'] . '">Update</a>

            ->rawColumns(['actions', 'checkbox'])
            ->make(true);
    }
    // show user page
    function addUsers()
    {
        $roleDetails = Role::select('role_id', 'role_name')->where('role_id','!=',1)->get();
        return view('super_admin.users.add', ['roleDetails' => $roleDetails]);
    }
    // add roleUser
    function addRoleUser(Request $request){

        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'role_name' => 'required',
            'password' => 'required',
            'email' => 'required|unique:users',
            // 'student_id' => 'unique:users',
        ]);

        if (!$validator->passes()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $user = new User();
            $user->name = $request->name;
            $user->role_id = $request->role_name;
            $user->password = Hash::make($request->password);
            $user->email = $request->email;
            $user->citizenship = $request->citizenship;
            $user->occupation = $request->occupation;
            $user->student_id = $request->student_id;
            $user->address = $request->address;
            $user->age = $request->age;

            $query = $user->save();

            if (!$query) {
                return response()->json(['code' => 0, 'msg' => 'Something went wrong']);
            } else {
                return response()->json(['code' => 1, 'msg' => 'New User has been successfully saved']);
            }
        }
    }

    //GET editDetails
    // public function editUser(Request $request)
    // {
    //     $userID = $request->route('id');
    //     $roleDetails = Role::select('role_id', 'role_name')->where('role_id','!=',1)->get();
    //     $users = User::join('roles', 'users.role_id', '=', 'roles.role_id')
    //         ->where('users.id',$userID)
    //         ->get(['users.id','users.name', 'users.role_id', 'roles.role_name', 'roles.role_slug']);
    //     dd($users);
    //     return view('super_admin.users.edit', ['roleDetails' => $roleDetails,'userDetails' => $users]);
    // }

    // DELETE User Details
    public function deleteUser(Request $request)
    {
        // dd($request->id);
        $id = $request->id;
        // $query = User::where('id', $id)->delete();
        $query = User::find($id)->delete();

        if ($query) {
            return response()->json(['code' => 1, 'msg' => 'User has been deleted from database']);
        } else {
            return response()->json(['code' => 0, 'msg' => 'Something went wrong']);
        }
    }

}
