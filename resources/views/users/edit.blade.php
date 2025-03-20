@extends('layouts.master')
@section('title', 'Edit User')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="mb-0 text-dark"><i class="fas fa-user-edit"></i> Edit User</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Restrict access: Only Admins, Employees (limited), and the user themselves can edit -->
                    @can('edit_users')
                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                        id="name" name="name" 
                                        value="{{ old('name', $user->name) }}" 
                                        placeholder="Enter user name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Admins can edit email, others cannot -->
                            @can('edit_users')
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                        id="email" name="email" 
                                        value="{{ old('email', $user->email) }}" 
                                        placeholder="Enter user email" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @else
                            <input type="hidden" name="email" value="{{ $user->email }}">
                            @endcan

                            <!-- Password Section -->
                            @can('change_password')
                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    Password 
                                    <small class="text-muted">(leave empty to keep current password)</small>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                        id="password" name="password" 
                                        placeholder="Enter new password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">
                                    Confirm Password
                                    <small class="text-muted">(if changing password)</small>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" 
                                        id="password_confirmation" name="password_confirmation" 
                                        placeholder="Confirm new password">
                                </div>
                            </div>
                            @endcan

                            <!-- Role Selection (Admins only) -->
                            @can('edit_users')
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                    <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                                        <option value="user" {{ $user->hasRole('user') ? 'selected' : '' }}>Normal User</option>
                                        <option value="employee" {{ $user->hasRole('employee') ? 'selected' : '' }}>Employee</option>
                                        <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>Admin</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @endcan

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Update User
                                </button>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to Users
                                </a>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-danger">
                            <p>You are not authorized to edit this user.</p>
                        </div>
                    @endcan
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
    .input-group-text {
        width: 40px;
        justify-content: center;
    }
</style>
@endpush
