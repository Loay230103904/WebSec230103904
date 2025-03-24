@extends('layouts.master')
@section('title', 'Products')

@section('content')
<div class="container mt-4">
    <h2>Products</h2>
    @if(auth()->user()->isAdmin() || auth()->user()->isEmployee())
        <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add Product</a>
    @endif

    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4 mb-3">
            <div class="card">
                @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid" style="max-width: 150px;">
            @else
                <p>No image available</p>
            @endif
            
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <p><strong>Price:</strong> ${{ $product->price }}</p>
                    <p><strong>Stock:</strong> {{ $product->stock }}</p>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-info">View</a>

                    @if(auth()->user()->isAdmin() || auth()->user()->isEmployee())
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{ $products->links() }}
</div>
@endsection
