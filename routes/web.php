<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'dologin'])->name('dologin');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Tasks
    Route::get('/task/create', [TaskController::class, 'create'])->name('task.create');
    Route::get('/task/index', [TaskController::class, 'index'])->name('task.index');
    Route::post('/task/store', [TaskController::class, 'store'])->name('task.store');
    Route::get('/task/{id}/views', [TaskController::class, 'views'])->name('task.views');
    Route::get('/task/{id}/edit', [TaskController::class, 'edit'])->name('task.edit');
    Route::post('/task/{id}/update', [TaskController::class, 'update'])->name('task.update');
    Route::post('/task/{id}/destroy', [TaskController::class, 'destroy'])->name('task.destroy');

    //Project
    Route::get('/project/create', [ProjectController::class, 'create'])->name('project.create');
    Route::get('/project/index', [ProjectController::class, 'index'])->name('project.index');
    Route::post('/project/store', [ProjectController::class, 'store'])->name('project.store');
    Route::get('/project/{id}/views', [ProjectController::class, 'views'])->name('project.views');
    Route::get('/project/{id}/edit', [ProjectController::class, 'edit'])->name('project.edit');
    Route::put('/project/{id}/update', [ProjectController::class, 'update'])->name('project.update');
    Route::post('/project/{id}/destroy', [ProjectController::class, 'destroy'])->name('project.destroy');


    Route::get('/project/{departmentId}/users', [ProjectController::class, 'getUsersByDepartment'])->name('project.user');
    Route::get('/project/{id}/projecttask',[ProjectController::class,'projecttask'])->name('project.projecttask');
    Route::post('/update-task-status', [ProjectController::class, 'updateTaskStatus'])->name('updateTaskStatus');

    //User
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/index', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/{id}/views', [UserController::class, 'views'])->name('user.views');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::match(['put', 'post'], '/user/{id}/update', [UserController::class, 'update'])->name('user.update');
    Route::post('/user/{id}/destroy', [UserController::class, 'destroy'])->name('user.destroy');

    //Department
    Route::get('/department/create', [DepartmentController::class, 'create'])->name('department.create');
    Route::post('/department/store', [DepartmentController::class, 'store'])->name('department.store');
    Route::post('/department/{id}/update', [DepartmentController::class, 'update'])->name('department.update');
    Route::post('/department/{id}/destroy', [DepartmentController::class, 'destroy'])->name('department.destroy');


    //Report
    Route::get('/report', [ReportController::class, 'index'])->name('report');


    Route::get('project/tasks', [ProjectController::class, 'getTasks'])->name('project.task');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});



