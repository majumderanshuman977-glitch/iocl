@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content">

            <div class="page-header">
                <div class="page-title">
                    {{-- <h4>Distribution Location Management</h4> --}}
                    <h6>Add Location</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <form action="{{ route('location.store') }}" method="POST">
                        @csrf

                        <div class="row">

                            <!-- Location Name -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Location Name<span class="text-danger">*</span></label>
                                    <input type="text" name="location_name" class="form-control"
                                        value="{{ old('location_name') }}" required>

                                    @error('location_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Address field --}}
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Address <span class="text-danger">*</span></label>
                                    <input type="text" name="address" class="form-control" value="{{ old('address') }}"
                                        required>

                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>




                            <!-- Categories with Price -->
                            <div class="col-lg-12 mt-3">
                                {{-- <label><strong>Cylinder Categories & Price</strong></label> --}}

                                <div class="row">
                                    @foreach ($cylinder_categories as $index => $category)
                                        <div class="col-lg-3">
                                            <div class="form-group">

                                                {{-- <h6 class="mb-2">{{ $category->name }}</h6> --}}
                                                <label>Cylinder {{ $category->name }} price  <span class="text-danger">*</span></label>
                                                <!-- Correct field names -->
                                                <input type="hidden"
                                                    name="cylinder_categories[{{ $index }}][category_id]"
                                                    value="{{ $category->id }}">

                                                <input type="number" step="0.01"
                                                    name="cylinder_categories[{{ $index }}][price]"
                                                    class="form-control " placeholder="Enter Price">

                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @error('cylinder_categories')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                @error('cylinder_categories.*.category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                @error('cylinder_categories.*.price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>



                            <!-- Buttons -->
                            <div class="col-lg-12 mt-3">
                                <button type="submit" class="btn btn-submit me-2">
                                    Submit
                                </button>
                                <a href="{{ route('location.list') }}" class="btn btn-cancel">
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
