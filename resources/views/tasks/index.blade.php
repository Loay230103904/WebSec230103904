@extends('layouts.master')
@section('title', 'Tasks')

@section('content')
<div class="container">
    <h2>To-Do List</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="input-group mb-3">
            <input type="text" name="name" class="form-control" placeholder="Enter task..." required>
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Add</button>
            </div>
        </div>
    </form>

    <ul class="list-group">
        @foreach ($tasks as $task)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span class="{{ $task->status ? 'text-success' : '' }}">{{ $task->name }}</span>
                <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-{{ $task->status ? 'secondary' : 'success' }}">
                        {{ $task->status ? 'Mark as Pending' : 'Mark as Completed' }}
                    </button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
@endsection
