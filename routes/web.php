<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;





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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/multable', function (Request $request) {
    $j = $request->input('number', 5); // Default to 5 if 'number' isn't provided
    return view('multable', compact('j'));
});//multable.blade.php
 Route::get('/even', function () {
    return view('even'); //even.blade.php
 });
 Route::get('/prime', function () {
    return view('prime'); //prime.blade.php
 });

 Route::get('/minitest', function () {
    $bill=[
    ['item'=>'jim','quantity'=>5,'price'=>12.50],
    ['item'=>'tea','quantity'=>15,'price'=>32.00],
    ['item'=>'banana','quantity'=>22,'price'=>15.75],
    ['item'=>'Rice','quantity'=>50,'price'=>2.20],
    ];
    return view('minitest',compact("bill"));
 });
 Route::get('/transcript', function () {
    $student=[
   'name'=>'loay',
   'id'=>'12345',
   'departement'=>'Network',
   'Gpa'=>3.9,
   'courses'=>[
    ['code'=>'CS50','name'=>'OOP','Grade'=>'A'],
    ['code'=>'CS50','name'=>'OOP','Grade'=>'A'],
    ['code'=>'CS50','name'=>'OOP','Grade'=>'A'],

   ]
    ];
    return view('transcript',compact("student"));
 })
 ;


 

// ✅ الصفحة الرئيسية (متاحة لأي مستخدم مسجل دخول)
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('home');
});

// ✅ تسجيل الدخول والتسجيل
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ✅ الملف الشخصي (متاح للجميع)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [UsersController::class, 'profile'])->name('users.profile');
    Route::post('/profile', [UsersController::class, 'updateProfile'])->name('users.profile.update');


    // ✅ المهام (متاحة لأي مستخدم مسجل دخول)
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');

    // ✅ إدارة المستخدمين (Admins فقط) - التحقق داخل الكنترولر
    Route::resource('users', UsersController::class);

    // ✅ تغيير كلمة المرور (متاح للجميع)
    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [AuthController::class, 'updatePassword'])->name('password.update');

    
});

Route::resource('products', ProductController::class);
Route::post('/products/{product}/purchase', [ProductController::class, 'purchase'])
    ->name('products.purchase')
    ->middleware('auth');
Route::post('/users/{user}/add-credit', [UsersController::class, 'addCredit'])->name('users.addCredit');


