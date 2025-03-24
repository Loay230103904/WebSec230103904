@extends('layouts.master')
@section('title', 'User Details')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0"><i class="fas fa-user"></i> User Details</h4>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Users
                        </a>

                        @if(auth()->user()->isAdmin() || auth()->user()->id === $user->id || 
                            (auth()->user()->isEmployee() && !$user->isAdmin()))
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Profile
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
</style>
@endpush
