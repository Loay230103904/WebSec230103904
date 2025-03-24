@extends('layouts.master')
@section('title', 'Users')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col">
            <h2>Users</h2>
        </div>
        <div class="col text-end">
            @if(auth()->user()->isAdmin()) {{-- Only Admins can create users --}}
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Create User
            </a>
            @endif
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('users.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="name" class="form-control" placeholder="Search by name" 
                            value="{{ request('name') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="text" name="email" class="form-control" placeholder="Search by email" 
                            value="{{ request('email') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    @if(request('name') || request('email'))
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td> <!-- ✅ عرض الدور لكل مستخدم -->
                                <td class="text-end">
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    
                                    @if(auth()->user()->isAdmin() || auth()->user()->id === $user->id || 
                                        (auth()->user()->isEmployee() && !$user->isAdmin()))
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    @endif

                                    @if(auth()->user()->isAdmin()) {{-- Only Admins can delete users --}}
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" 
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Are you sure you want to delete this user?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No users found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush
