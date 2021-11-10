<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\StudentController;

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

    // userlist routes
    Route::get('users/user', [SuperAdminController::class, 'users'])->name('users.user');
    Route::get('users/add', [SuperAdminController::class, 'addUsers'])->name('users.add');
    Route::post('users/add_user', [SuperAdminController::class, 'addRoleUser'])->name('users.add_role_user');
    Route::get('users/edit/{id}', [SuperAdminController::class, 'editUser'])->name('users.edit');
    Route::get('users/user_list', [SuperAdminController::class, 'getUserList'])->name('users.user_list');
    Route::post('users/delete', [SuperAdminController::class, 'deleteUser'])->name('users.delete');

    // settings
    Route::get('settings', [SuperAdminController::class, 'settings'])->name('super_admin.settings');
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
