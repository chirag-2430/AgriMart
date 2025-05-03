@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">{{ $product->name }}</h3>
                </div>

                <div class="card-body">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid mb-4" alt="{{ $product->name }}">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" class="img-fluid mb-4" alt="No image">
                    @endif

                    <div class="mb-4">
                        <h5>Description</h5>
                        <p>{{ $product->description }}</p>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Price</h5>
                            <p>${{ number_format($product->price, 2) }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Stock</h5>
                            <p>{{ $product->stock }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Category</h5>
                            <p>{{ $product->category->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Supplier</h5>
                            <p>{{ $product->supplier->name }}</p>
                        </div>
                    </div>

                    @if(auth()->check() && auth()->user()->isFarmer())
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-4">
                            @csrf
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" name="quantity" id="quantity" class="form-control" min="1" max="{{ $product->stock }}" value="1">
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Add to Cart</button>
                        </form>
                    @endif

                    @if(auth()->check() && (auth()->user()->isSupplier() || auth()->user()->isAdmin()))
                        <div class="mt-4">
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Edit Product</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete Product</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 