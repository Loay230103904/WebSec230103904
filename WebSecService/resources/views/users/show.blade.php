@extends('layouts.master')
@section('title', 'User Details')

@section('content')
    <h2>User Details</h2>
    <p><strong>Name:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <a href="{{ route('users.index') }}">Back to list</a>
@endsection
