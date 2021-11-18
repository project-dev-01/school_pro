<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Role;
use App\Models\Section;
use App\Models\SectionAllocation;
use App\Models\TeacherAllocation;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class SuperAdminController extends Controller
{
    //
    public function index()
    {
        return view('super_admin.dashboard.index');
    }
    public function settings()
    {
        return view('super_admin.settings.index');
    }
    public function classes()
    {
        return view('super_admin.classes.index');
    }
    public function addClasses()
    {
        $teacherDetails = User::select('id', 'name')->where('role_id', 3)->get();
        return view('super_admin.classes.add', ['teacherDetails' => $teacherDetails]);
    }

    // update profile info
    public function updateProfileInfo(Request $request){
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
    public function updatePicture(Request $request){
        
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
    public function changePassword(Request $request){
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
            'name' => 'required|unique:classes',
            'name_numeric' => 'required',
        ]);

        if (!$validator->passes()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $class = new Classes();
            $class->name = $request->name;
            $class->name_numeric = $request->name_numeric;
            $query = $class->save();

            if (!$query) {
                return response()->json(['code' => 0, 'msg' => 'Something went wrong']);
            } else {
                return response()->json(['code' => 1, 'msg' => 'New Class has been successfully saved']);
            }
        }
    }

    // get class row details
    public function getClassDetails(Request $request){
        $class_id = $request->class_id;
        $classDetails = Classes::find($class_id);
        return response()->json(['details'=>$classDetails]);
    }

    // get class details
    public function getClassList(Request $request)
    {
        $classes = Classes::all();
        
        return DataTables::of($classes)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                return '<div class="button-list">
                                <a href="javascript:void(0)" class="btn btn-blue waves-effect waves-light" data-id="' . $row['id'] . '" id="editClassBtn">Update</a>
                                <a href="javascript:void(0)" class="btn btn-danger waves-effect waves-light" data-id="' . $row['id'] . '" id="deleteClassBtn">Delete</a>
                        </div>';
            })

            ->rawColumns(['actions'])
            ->make(true);
    }

    //UPDATE Class DETAILS
    public function updateClass(Request $request)
    {
        // dd($request);
        $classID = $request->class_id;

        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'name_numeric' => 'required',
        ]);

        if (!$validator->passes()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {

            $class = Classes::find($classID);
            $class->name = $request->name;
            $class->name_numeric = $request->name_numeric;
            $query = $class->save();

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
        Classes::where('id', $classID)->delete();
        return response()->json(['code'=>1, 'msg'=>'Class have been deleted from database']); 

        // if ($query) {
        //     return response()->json(['code' => 1, 'msg' => 'Class has been deleted from database']);
        // } else {
        //     return response()->json(['code' => 0, 'msg' => 'Something went wrong']);
        // }
    }

    // users page
    public function users()
    {
        return view('super_admin.users.index');
    }

    // get users details
    public function getUserList(Request $request)
    {
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

            ->rawColumns(['actions', 'checkbox'])
            ->make(true);
    }
    // show user page
    public function addUsers()
    {
        $roleDetails = Role::select('role_id', 'role_name')->where('role_id','!=',1)->get();
        return view('super_admin.users.add', ['roleDetails' => $roleDetails]);
    }
    // add roleUser
    public function addRoleUser(Request $request){

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

    // DELETE User Details
    public function deleteUser(Request $request)
    {
        $id = $request->id;
        $query = User::find($id)->delete();

        if ($query) {
            return response()->json(['code' => 1, 'msg' => 'User has been deleted from database']);
        } else {
            return response()->json(['code' => 0, 'msg' => 'Something went wrong']);
        }
    }

    // get section
    public function section()
    {
        return view('super_admin.section.index');
    }
    // add section
    public function addSection(Request $request){

        $validator = \Validator::make($request->all(),[
            'name'=>'required|unique:sections'
        ]);

        if(!$validator->passes()){
             return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
            $section = new Section();
            $section->name = $request->name;
            $query = $section->save();

            if(!$query){
                return response()->json(['code'=>0,'msg'=>'Something went wrong']);
            }else{
                return response()->json(['code'=>1,'msg'=>'New Section has been successfully saved']);
            }
        }
    }

    // get sections 
    public function getSectionList(Request $request)
    {
        $section = Section::all();
        return DataTables::of($section)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                return '<div class="button-list">
                                <a href="javascript:void(0)" class="btn btn-blue waves-effect waves-light" data-id="' . $row['id'] . '" id="editSectionBtn">Update</a>
                                <a href="javascript:void(0)" class="btn btn-danger waves-effect waves-light" data-id="' . $row['id'] . '" id="deleteSectionBtn">Delete</a>
                        </div>';
            })

            ->rawColumns(['actions'])
            ->make(true);
    }

    // get section row details
    public function getSectionDetails(Request $request){
        $section_id = $request->section_id;
        $sectionDetails = Section::find($section_id);
        return response()->json(['details'=>$sectionDetails]);
    }
    // update section
    public function updateSectionDetails(Request $request){
        $section_id = $request->sid;

        $validator = \Validator::make($request->all(),[
            'name'=>'required|unique:sections,name,'.$section_id
        ]);

        if(!$validator->passes()){
               return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
             
            $section = Section::find($section_id);
            $section->name = $request->name;
            $query = $section->save();

            if($query){
                return response()->json(['code'=>1, 'msg'=>'Section Details have Been updated']);
            }else{
                return response()->json(['code'=>0, 'msg'=>'Something went wrong']);
            }
        }
    }
    // delete Section
    public function deleteSection(Request $request){
        $section_id = $request->section_id;
        Section::where('id', $section_id)->delete();
        return response()->json(['code'=>1, 'msg'=>'Section have been deleted from database']); 
    }

     // section allocations
    public function showSectionAllocation(){
        $classDetails = Classes::select('id', 'name')->get();
        $sectionDetails = Section::select('id', 'name')->get();
        return view('super_admin.section_allocation.allocation', ['classDetails' => $classDetails,'sectionDetails' => $sectionDetails]);
    }

    // add section allocations
    public function addSectionAllocation(Request $request){

        $validator = \Validator::make($request->all(),[
            'class_name'=>'required',
            'section_name'=>'required'
        ]);

        if(!$validator->passes()){
             return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
            $section = new SectionAllocation();
            $section->class_id = $request->class_name;
            $section->section_id = $request->section_name;
            $query = $section->save();

            if(!$query){
                return response()->json(['code'=>0,'msg'=>'Something went wrong']);
            }else{
                return response()->json(['code'=>1,'msg'=>'Section Allocation has been successfully saved']);
            }
        }
    }
    // get sections allocation
    public function getSectionAllocationList(Request $request)
    {
        $sectionAllocation = DB::table('sections_allocations as sa')
            ->select('sa.id','sa.class_id','sa.section_id','s.name as section_name','c.name as class_name','c.name_numeric')
            ->join('sections as s', 'sa.section_id', '=', 's.id')
            ->join('classes as c', 'sa.class_id', '=', 'c.id')
            ->get();

        return DataTables::of($sectionAllocation)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                return '<div class="button-list">
                                <a href="javascript:void(0)" class="btn btn-blue waves-effect waves-light" data-id="' . $row->id . '" id="editSectionAlloBtn">Update</a>
                                <a href="javascript:void(0)" class="btn btn-danger waves-effect waves-light" data-id="' . $row->id . '" id="deleteSectionAlloBtn">Delete</a>
                        </div>';
            })

            ->rawColumns(['actions'])
            ->make(true);
    }

    // get getSectionAllocationDetails details

    public function getSectionAllocationDetails(Request $request){
        $id = $request->id;
        $SectionAllocation = SectionAllocation::find($id);
        return response()->json(['details'=>$SectionAllocation]);
    }

    // update Section Allocations

    public function updateSectionAllocation(Request $request){
        $id = $request->said;

        $validator = \Validator::make($request->all(),[
            'class_name'=>'required',
            'section_name'=>'required'
        ]);

        if(!$validator->passes()){
               return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{

            $section = SectionAllocation::find($id);
            $section->class_id = $request->class_name;
            $section->section_id = $request->section_name;
            $query = $section->save();

            if($query){
                return response()->json(['code'=>1, 'msg'=>'Section Allocation Details have Been updated']);
            }else{
                return response()->json(['code'=>0, 'msg'=>'Something went wrong']);
            }
        }
    }

    // delete deleteSectionAllocation
    public function deleteSectionAllocation(Request $request){
        $id = $request->id;
        SectionAllocation::where('id', $id)->delete();
        return response()->json(['code'=>1, 'msg'=>'Section Allocation have been deleted from database']); 
    }

    // show assign teacher

    public function showAssignTeacher(){
        $classDetails = Classes::select('id', 'name')->get();
        $teacherDetails = User::select('id', 'name')->where('role_id', 3)->get();
        return view('super_admin.assign_teacher.index', ['classDetails' => $classDetails,'teacherDetails' => $teacherDetails]);
    }
    // get allocation section

    public function getAllocationSection(Request $request){
        $class_id = $request->class_id;

        $classDetails = DB::table('sections_allocations as sa')
            ->select('sa.id','sa.class_id','sa.section_id','s.name as section_name')
            ->join('sections as s', 'sa.section_id', '=', 's.id')
            ->where('sa.class_id', $class_id)
            ->get();
            
        return response()->json(['code'=>1, 'data'=>$classDetails]); 
    }

    // add section allocations
    public function addTeacherAllocation(Request $request){

        $validator = \Validator::make($request->all(),[
            'class_name'=>'required',
            'section_name'=>'required',
            'class_teacher'=>'required'
        ]);

        if(!$validator->passes()){
             return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{

            $teacherAllocation = new TeacherAllocation();
            $teacherAllocation->class_id = $request->class_name;
            $teacherAllocation->section_id = $request->section_name;
            $teacherAllocation->teacher_id = $request->class_teacher;
            $query = $teacherAllocation->save();

            if(!$query){
                return response()->json(['code'=>0,'msg'=>'Something went wrong']);
            }else{
                return response()->json(['code'=>1,'msg'=>'Teacher Allocation has been successfully saved']);
            }
        }
    }

    // get Teacher Allocation List

    public function getTeacherAllocationList(Request $request)
    {
        $teacherAllocation = DB::table('teacher_allocations as ta')
            ->select('ta.id','ta.class_id','ta.section_id','ta.teacher_id','s.name as section_name','c.name as class_name','u.name as teacher_name')
            ->join('sections as s', 'ta.section_id', '=', 's.id')
            ->join('classes as c', 'ta.class_id', '=', 'c.id')
            ->join('users as u', 'ta.teacher_id', '=', 'u.id')
            ->get();

        return DataTables::of($teacherAllocation)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                return '<div class="button-list">
                                <a href="javascript:void(0)" class="btn btn-blue waves-effect waves-light" data-id="' . $row->id . '" id="editTeacherAlloBtn">Update</a>
                                <a href="javascript:void(0)" class="btn btn-danger waves-effect waves-light" data-id="' . $row->id . '" id="deleteTeacherAlloBtn">Delete</a>
                        </div>';
            })

            ->rawColumns(['actions'])
            ->make(true);
    }
}
