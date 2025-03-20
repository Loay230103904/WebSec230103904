@extends('layouts.master')
@section('title', 'Mini Test')
@section('content')
<div class="container mt-5">
    <h2>Bill Items</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bill as $item)
                <tr>
                    <td>{{ $item['item'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ $item['price'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
