<!-- resources/views/products/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $product->title }}</h1>
        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid" alt="{{ $product->title }}">
        <p><strong>Descripción:</strong> {{ $product->description }}</p>
        <p><strong>Precio:</strong> ${{ $product->price }}</p>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Volver a los productos</a>
    </div>
@endsection
