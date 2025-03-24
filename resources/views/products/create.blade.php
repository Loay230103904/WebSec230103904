@extends('layouts.master')
@section('title', 'Add Product')

@section('content')
<div class="container mt-4">
    <h2>Add Product</h2>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="name" class="form-control mb-2" placeholder="Product Name" required>
        <textarea name="description" class="form-control mb-2" placeholder="Product Description" required></textarea>
        <input type="number" name="price" class="form-control mb-2" placeholder="Price" required>
        <input type="number" name="stock" class="form-control mb-2" placeholder="Stock" required>
        <input type="file" name="image" class="form-control mb-2">
        <button type="submit" class="btn btn-primary">Add Product</button>
    </form>
</div>
@endsection
