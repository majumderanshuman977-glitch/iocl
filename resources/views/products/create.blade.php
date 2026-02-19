@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Product Management</h4>
                    <h6>Add Product</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Product Name<span class="text-danger">*</span></label>
                                    <input type="text" name="product_name" class="form-control"
                                        value="{{ old('product_name') }}" required>
                                    @error('product_name')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Price</label>
                                    {{-- dont want number want float --}}
                                    <input type="number" step="0.01" name="price" class="form-control"
                                        value="{{ old('price', 0) }}" required>
                                    @error('price')
                                        <span class="text-danger">
                                                {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="number" name="quantity" class="form-control"
                                        value="{{ old('quantity', 0) }}" min="0" required>
                                    @error('quantity')
                                        <span class="text-danger">
                                                {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="text-danger">
                                                {{ $message }}
                                        </span>
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

                                        <div id="uploadPlaceholder">
                                            <img src="{{ asset('assets/img/icons/upload.svg') }}"
                                                style="width:40px; margin-bottom:10px;">
                                            <h6 class="mb-0">Click or drag image to upload</h6>
                                        </div>

                                        <img id="previewImage" src="" class="img-fluid mt-2"
                                            style="max-height:120px; display:none;">
                                    </div>

                                    @error('product_image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">
                                    Submit
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
@section('script')
    <script>
        document.getElementById('imageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            let reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('previewImage').src = event.target.result;
                document.getElementById('previewImage').style.display = 'block';
                document.getElementById('uploadPlaceholder').style.display = 'none';
            };
            reader.readAsDataURL(file);
        });
    </script>
@endsection
