@extends('layouts.master')

@section('title', 'Edit Product')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="mb-0 text-dark"><i class="fas fa-edit"></i> Edit Product</h4>
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

                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                value="{{ old('name', $product->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price ($)</label>
                            <input type="number" class="form-control" id="price" name="price" 
                                value="{{ old('price', $product->price) }}" step="0.01" required>
                        </div>

                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock Quantity</label>
                            <input type="number" class="form-control" id="stock" name="stock" 
                                value="{{ old('stock', $product->stock) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Product Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                            @if ($product->image)
                                <p class="mt-2">Current Image:</p>
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="img-fluid rounded" style="max-width: 150px;">
                            @endif
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Update Product
                            </button>
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Products
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
