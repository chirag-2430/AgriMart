@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">{{ __('Products') }}</h3>
                    @if(auth()->check() && (auth()->user()->isSupplier() || auth()->user()->isAdmin()))
                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                            {{ __('Add New Product') }}
                        </a>
                    @endif
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row">
                        @foreach($products as $product)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                                    @else
                                        <img src="{{ asset('images/no-image.png') }}" class="card-img-top" alt="No image">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                        <p class="card-text">
                                            <strong>Price:</strong> ${{ number_format($product->price, 2) }}
                                        </p>
                                        <p class="card-text">
                                            <strong>Stock:</strong> {{ $product->stock }}
                                        </p>
                                        <p class="card-text">
                                            <strong>Category:</strong> {{ $product->category->name }}
                                        </p>
                                        <p class="card-text">
                                            <strong>Supplier:</strong> {{ $product->supplier->name }}
                                        </p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('products.show', $product) }}" class="btn btn-primary">View Details</a>
                                        @if(auth()->check() && (auth()->user()->isSupplier() || auth()->user()->isAdmin()))
                                            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Edit</a>
                                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 