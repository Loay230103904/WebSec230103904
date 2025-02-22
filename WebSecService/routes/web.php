<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


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
