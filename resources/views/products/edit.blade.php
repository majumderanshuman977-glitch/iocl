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

                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <!-- Product Name -->
                            <div class="col-lg-5">
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
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="number" name="price" class="form-control"
                                        value="{{ old('price', $product->price) }}" min="0"  step="0.01" required>
                                    @error('price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                               <!-- CGST -->
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label>CGST (%)</label>
                                    <input type="number" step="0.01" name="cgst" class="form-control"
                                        value="{{ old('cgst', $product->cgst) }}" min="0" required>
                                    @error('cgst')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- SGST -->
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label>SGST (%)</label>
                                    <input type="number" step="0.01" name="sgst" class="form-control"
                                        value="{{ old('sgst',$product->sgst) }}" min="0" required>
                                    @error('sgst')
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

                            {{-- image upload  --}}

                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Product Image</label>

                                    <div class="image-upload-box text-center p-3 border rounded position-relative">
                                        <input type="file" name="product_image" id="imageInput" accept="image/*"
                                            class="position-absolute w-100 h-100 top-0 start-0 opacity-0"
                                            style="cursor: pointer;">

                                        <div id="uploadPlaceholder"
                                            {{ $product->product_image ? 'style=display:none;' : '' }}>
                                            <img src="{{ asset('assets/img/icons/upload.svg') }}"
                                                style="width:40px; margin-bottom:10px;">
                                            <h6 class="mb-0">Click or drag image to upload</h6>
                                        </div>

                                        <img id="previewImage"
                                            src="{{ $product->product_image ? asset('storage/' . $product->product_image) : '' }}"
                                            class="img-fluid mt-2"
                                            style="max-height:120px; {{ $product->product_image ? '' : 'display:none;' }}">
                                    </div>

                                    @error('product_image')
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
@section('script')
    <script>
        document.getElementById('imageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('previewImage').src = event.target.result;
                    document.getElementById('previewImage').style.display = 'block';
                    document.getElementById('uploadPlaceholder').style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
@endsection
