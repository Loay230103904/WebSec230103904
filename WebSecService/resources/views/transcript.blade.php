@extends('layouts.master')
@section('title', 'Transcript')
@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Student Information</h5>
            <p class="card-text"><strong>Name:</strong> {{ $student['name'] }}</p>
            <p class="card-text"><strong>ID:</strong> {{ $student['id'] }}</p>
            <p class="card-text"><strong>Department:</strong> {{ $student['departement'] }}</p>
            <p class="card-text"><strong>GPA:</strong> {{ $student['Gpa'] }}</p>
        </div>
    </div>
    <h2 class="mt-5">Courses</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($student['courses'] as $course)
                <tr>
                    <td>{{ $course['code'] }}</td>
                    <td>{{ $course['name'] }}</td>
                    <td>{{ $course['Grade'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
