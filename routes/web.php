<?php

use App\Http\Controllers\AbsenceTypeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\MealScheduleController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes(['register' => false]);

Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

// Profile Routes
Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'getProfile'])->name('detail');
    Route::post('/update', [HomeController::class, 'updateProfile'])->name('update');
    Route::post('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
});

// Roles
Route::resource('roles', App\Http\Controllers\RolesController::class);

// Permissions
Route::resource('permissions', App\Http\Controllers\PermissionsController::class);

// Users
Route::middleware('auth')->group(function () {
    Route::prefix('attendances')->name('attendances.')->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('index');
        Route::get('/report', [AttendanceController::class, 'report'])->name('report');
        Route::get('/reportFiltered', [AttendanceController::class, 'reportFiltered'])->name('reportFiltered');
        Route::get('/exportDepartmentFilterReport', [AttendanceController::class, 'exportDepartmentFilterReport'])->name('exportDepartmentFilterReport');
        Route::get('/exportDepartmentReport', [AttendanceController::class, 'exportDepartmentReport'])->name('exportDepartmentReport');
        Route::get('/export1cReport', [AttendanceController::class, 'export1cReport'])->name('export1cReport');
        Route::get('/departmentReport', [AttendanceController::class, 'departmentReport'])->name('departmentReport');
        Route::get('/report1c', [AttendanceController::class, 'report1c'])->name('report1c');
        Route::get('/employeesReport', [AttendanceController::class, 'employeesReport'])->name('employeesReport');
        Route::get('/exportEmployeesReport', [AttendanceController::class, 'exportEmployeesReport'])->name('exportEmployeesReport');
        Route::get('/create', [AttendanceController::class, 'create'])->name('create');
        Route::post('/store', [AttendanceController::class, 'store'])->name('store');
        Route::post('/copyFromDate', [AttendanceController::class, 'copyFromDate'])->name('copyFromDate');
        Route::get('/edit/{attendance}', [AttendanceController::class, 'edit'])->name('edit');
        Route::put('/update/{attendance}', [AttendanceController::class, 'update'])->name('update');
        Route::delete('/delete/{attendance}', [AttendanceController::class, 'delete'])->name('destroy');
    });

    Route::prefix('departments')->name('departments.')->group(function () {
        Route::get('/', [DepartmentController::class, 'index'])->name('index');
        Route::get('/create', [DepartmentController::class, 'create'])->name('create');
        Route::post('/store', [DepartmentController::class, 'store'])->name('store');
        Route::get('/edit/{department}', [DepartmentController::class, 'edit'])->name('edit');
        Route::put('/update/{department}', [DepartmentController::class, 'update'])->name('update');
        Route::delete('/delete/{department}', [DepartmentController::class, 'delete'])->name('destroy');
    });

    Route::prefix('absenceTypes')->name('absenceTypes.')->group(function () {
        Route::get('/', [AbsenceTypeController::class, 'index'])->name('index');
        Route::get('/create', [AbsenceTypeController::class, 'create'])->name('create');
        Route::post('/store', [AbsenceTypeController::class, 'store'])->name('store');
        Route::get('/edit/{absenceType}', [AbsenceTypeController::class, 'edit'])->name('edit');
        Route::put('/update/{absenceType}', [AbsenceTypeController::class, 'update'])->name('update');
        Route::delete('/delete/{absenceType}', [AbsenceTypeController::class, 'delete'])->name('destroy');
    });

    Route::prefix('positions')->name('positions.')->group(function () {
        Route::get('/', [PositionController::class, 'index'])->name('index');
        Route::get('/create', [PositionController::class, 'create'])->name('create');
        Route::post('/store', [PositionController::class, 'store'])->name('store');
        Route::get('/edit/{position}', [PositionController::class, 'edit'])->name('edit');
        Route::put('/update/{position}', [PositionController::class, 'update'])->name('update');
        Route::delete('/delete/{position}', [PositionController::class, 'delete'])->name('destroy');
    });

    Route::prefix('employees')->name('employees.')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('index');
        Route::get('/list', [EmployeeController::class, 'getList'])->name('list');
        Route::get('/create', [EmployeeController::class, 'create'])->name('create');
        Route::post('/store', [EmployeeController::class, 'store'])->name('store');
        Route::get('/edit/{employee}', [EmployeeController::class, 'edit'])->name('edit');
        Route::put('/update/{employee}', [EmployeeController::class, 'update'])->name('update');
        Route::delete('/delete/{employee}', [EmployeeController::class, 'delete'])->name('destroy');
    });

    Route::prefix('shifts')->name('shifts.')->group(function () {
        Route::get('/', [ShiftController::class, 'index'])->name('index');
        Route::get('/create', [ShiftController::class, 'create'])->name('create');
        Route::post('/store', [ShiftController::class, 'store'])->name('store');
        Route::get('/edit/{shift}', [ShiftController::class, 'edit'])->name('edit');
        Route::put('/update/{shift}', [ShiftController::class, 'update'])->name('update');
        Route::delete('/delete/{shift}', [ShiftController::class, 'delete'])->name('destroy');
    });

    Route::prefix('meals')->name('meals.')->group(function () {
        Route::get('/', [MealController::class, 'index'])->name('index');
        Route::get('/create', [MealController::class, 'create'])->name('create');
        Route::post('/store', [MealController::class, 'store'])->name('store');
        Route::get('/edit/{meal}', [MealController::class, 'edit'])->name('edit');
        Route::put('/update/{meal}', [MealController::class, 'update'])->name('update');
        Route::delete('/delete/{meal}', [MealController::class, 'delete'])->name('destroy');
    });

    Route::prefix('mealschedule')->name('mealschedule.')->group(function () {
        Route::get('/', [MealScheduleController::class, 'index'])->name('index');
        Route::get('/create', [MealScheduleController::class, 'create'])->name('create');
        Route::post('/store', [MealScheduleController::class, 'store'])->name('store');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
        Route::put('/update/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/delete/{user}', [UserController::class, 'delete'])->name('destroy');
        Route::get('/update/status/{user_id}/{status}', [UserController::class, 'updateStatus'])->name('status');


        Route::get('/import-users', [UserController::class, 'importUsers'])->name('import');
        Route::post('/upload-users', [UserController::class, 'uploadUsers'])->name('upload');

        Route::get('export/', [UserController::class, 'export'])->name('export');
    });
});
