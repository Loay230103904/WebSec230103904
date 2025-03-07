<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UsersController;



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

 Route::resource('users', UsersController::class);

