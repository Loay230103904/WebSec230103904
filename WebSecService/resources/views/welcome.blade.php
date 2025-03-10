@extends('layouts.master')

@section('title', 'Welcome')

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="card m-4">
    <div class="card-body">
        @auth
            <h3>Welcome, {{ Auth::user()->name }}!</h3>
        @else
            <h3>Welcome to Home Page</h3>
        @endauth
    </div>
</div>
@endsection
