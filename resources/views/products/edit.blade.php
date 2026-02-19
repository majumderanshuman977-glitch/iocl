@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Product Management</h4>
                    <h6>Edit Product</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <form action="{{ route('products.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <!-- Product Name -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Product Name</label>
                                    <input type="text" name="product_name" class="form-control"
                                        value="{{ old('product_name', $product->product_name) }}" required>
                                    @error('product_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="number" name="price" class="form-control"
                                        value="{{ old('price', $product->price) }}" min="0" required>
                                    @error('price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" rows="5">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">
                                    Update
                                </button>
                                <a href="{{ route('products.list') }}" class="btn btn-cancel">
                                    Cancel
                                </a>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
