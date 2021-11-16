<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return redirect(route('login'));
});
// Auth::routes();
Route::middleware(['middleware' => 'PreventBackHistory'])->group(function () {
    // Auth::routes([
    //     'register' => false
    // ]);
    Auth::routes();
});

Route::get('/forgotpassword', [ForgotPasswordController::class, 'forgotpassword'])->name('forgotpassword');
Route::post('/resetpassword', [ForgotPasswordController::class, 'resetpassword'])->name('resetpassword');
Route::post('/resetpasswordvalidation', [ResetPasswordController::class, 'resetPasswordValidation'])->name('password.reset');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'super_admin', 'middleware' => ['isSuperAdmin', 'auth', 'PreventBackHistory']], function () {
    Route::get('dashboard', [SuperAdminController::class, 'index'])->name('super_admin.dashboard');

    // class routes
    Route::get('classes', [SuperAdminController::class, 'classes'])->name('super_admin.classes');
    Route::get('classes/add_class', [SuperAdminController::class, 'addClasses'])->name('super_admin.add_classes');
    Route::get('classes/list', [SuperAdminController::class, 'getClassList'])->name('classes.list');
    Route::post('classes/add', [SuperAdminController::class, 'addClass'])->name('classes.add');
    Route::get('classes/edit/{id}', [SuperAdminController::class, 'editClass'])->name('classes.edit');
    Route::post('classes/update', [SuperAdminController::class, 'updateClass'])->name('classes.update');
    Route::post('classes/delete', [SuperAdminController::class, 'deleteClass'])->name('classes.delete');
    Route::post('classes/class-details',[SuperAdminController::class, 'getClassDetails'])->name('classes.details');

    // userlist routes
    Route::get('users/user', [SuperAdminController::class, 'users'])->name('users.user');
    Route::get('users/add', [SuperAdminController::class, 'addUsers'])->name('users.add');
    Route::post('users/add_user', [SuperAdminController::class, 'addRoleUser'])->name('users.add_role_user');
    Route::get('users/edit/{id}', [SuperAdminController::class, 'editUser'])->name('users.edit');
    Route::get('users/user_list', [SuperAdminController::class, 'getUserList'])->name('users.user_list');
    Route::post('users/delete', [SuperAdminController::class, 'deleteUser'])->name('users.delete');

    // settings
    Route::get('settings', [SuperAdminController::class, 'settings'])->name('super_admin.settings');
    Route::post('change-password',[SuperAdminController::class,'changePassword'])->name('changePassword');
    Route::post('update-profile-info',[SuperAdminController::class,'updateProfileInfo'])->name('updateProfileInfo');
    Route::post('change-profile-picture',[SuperAdminController::class,'updatePicture'])->name('pictureUpdate');
    // section routes
    Route::get('section/index', [SuperAdminController::class, 'section'])->name('super_admin.section');
    Route::post('section/add',[SuperAdminController::class,'addSection'])->name('section.add');
    Route::get('section/list', [SuperAdminController::class, 'getSectionList'])->name('section.list');
    Route::post('section/section-details',[SuperAdminController::class, 'getSectionDetails'])->name('section.details');
    Route::post('section/update',[SuperAdminController::class, 'updateSectionDetails'])->name('section.update');
    Route::post('section/delete', [SuperAdminController::class, 'deleteSection'])->name('section.delete');

});

Route::group(['prefix' => 'staff', 'middleware' => ['isStaff', 'auth', 'PreventBackHistory']], function () {
    Route::get('dashboard', [StaffController::class, 'index'])->name('staff.dashboard');
});

Route::group(['prefix' => 'teacher', 'middleware' => ['isTeacher', 'auth', 'PreventBackHistory']], function () {
    Route::get('dashboard', [TeacherController::class, 'index'])->name('teacher.dashboard');
});

Route::group(['prefix' => 'parent', 'middleware' => ['isParent', 'auth', 'PreventBackHistory']], function () {
    Route::get('dashboard', [ParentController::class, 'index'])->name('parent.dashboard');
});

Route::group(['prefix' => 'student', 'middleware' => ['isStudent', 'auth', 'PreventBackHistory']], function () {
    Route::get('dashboard', [StudentController::class, 'index'])->name('student.dashboard');
});
