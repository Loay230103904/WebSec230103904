@extends('layouts.master')
@section('title', 'Profile')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0"><i class="fas fa-user"></i> My Profile</h4>
                </div>
                <div class="card-body">
                    
                    {{-- ✅ Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- ✅ User Details --}}
                    <h5><i class="fas fa-user"></i> Name: {{ $user->name }}</h5>
                    <h5><i class="fas fa-envelope"></i> Email: {{ $user->email }}</h5>

                    {{-- ✅ Display Account Credit --}}
                    <div class="mt-4">
                        <h5><i class="fas fa-wallet"></i> Account Credit: 
                            <span class="badge bg-success">${{ number_format($user->credit, 2) }}</span>
                        </h5>
                    </div>

                    {{-- ✅ Display User Purchases --}}
                    <div class="mt-4">
                        <h4><i class="fas fa-shopping-cart"></i> My Purchases</h4>
                        @if($user->purchases->isNotEmpty())
                            <ul class="list-group">
                                @foreach($user->purchases as $purchase)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>
                                            <strong>{{ $purchase->product->name }}</strong> - ${{ $purchase->amount }}
                                        </span>
                                        <img src="{{ asset('storage/' . $purchase->product->image) }}" alt="{{ $purchase->product->name }}" class="img-thumbnail" style="width: 50px;">
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">No purchases yet.</p>
                        @endif
                    </div>

                    {{-- ✅ Back Button --}}
                    <a href="{{ route('home') }}" class="btn btn-secondary mt-3 w-100">
                        <i class="fas fa-arrow-left"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
