@extends('layouts.master')

@section('title', 'Product Details')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0"><i class="fas fa-box"></i> Product Details</h4>
                </div>
                <div class="card-body text-center">
                    
                    {{-- ✅ Product Image --}}
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" onerror="this.onerror=null;this.src='{{ asset('images/default.png') }}';" 
                            alt="Product Image" class="img-fluid mb-3" style="max-width: 200px;">
                    @else
                        <p>No image available</p>
                    @endif

                    {{-- ✅ Product Details --}}
                    <p><strong>Name:</strong> {{ $product->name }}</p>
                    <p><strong>Description:</strong> {{ $product->description }}</p>
                    <p><strong>Price:</strong> ${{ $product->price }}</p>
                    <p><strong>Stock:</strong> {{ $product->stock }}</p>

                    {{-- ✅ Check if user has enough credit --}}
                    @if(auth()->user()->role === 'user')
                        @if(auth()->user()->credit >= $product->price && $product->stock > 0)
                            <form action="{{ route('products.purchase', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Buy with Credit</button>
                            </form>
                        @else
                            <button class="btn btn-secondary" disabled>
                                @if($product->stock <= 0)
                                    Out of Stock
                                @else
                                    Insufficient Credit
                                @endif
                            </button>
                        @endif
                    @endif

                    {{-- ✅ Admin & Employee Options --}}
                    @if(auth()->user()->isAdmin() || auth()->user()->isEmployee())
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning mt-3">
                            <i class="fas fa-edit"></i> Edit Product
                        </a>
                    @endif

                    {{-- ✅ Back Button --}}
                    <div class="mt-3">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Products
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
