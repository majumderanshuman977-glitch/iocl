@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content">

            <div class="page-header">
                <div class="page-title">
                    <h6>Edit Location</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <form action="{{ route('location.update', $location->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <!-- Location Name -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Location Name <span class="text-danger">*</span></label>
                                    <input type="text" name="location_name" class="form-control"
                                        value="{{ old('location_name', $location->location_name) }}" required>

                                    @error('location_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Address <span class="text-danger">*</span></label>
                                    <input type="text" name="address" class="form-control"
                                        value="{{ old('address', $location->address) }}" required>

                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Categories with Price -->
                            <div class="col-lg-12 mt-3">


                                <div class="row">
                                    @foreach ($cylinder_categories as $index => $category)

                                        @php
                                            $existing = $location->locationCylinderCategories
                                                ->where('cylinder_category_id', $category->id)
                                                ->first();
                                        @endphp

                                        <div class="col-lg-3">
                                            <div class="form-group">

                                                {{-- <h6 class="mb-2">{{ $category->name }}</h6> --}}
                                                    <label>Cylinder {{ $category->name }} price <span class="text-danger">*</span></label>
                                                <input type="hidden"
                                                    name="cylinder_categories[{{ $index }}][category_id]"
                                                    value="{{ $category->id }}">

                                                <input type="number" step="0.01"
                                                    name="cylinder_categories[{{ $index }}][price]"
                                                    class="form-control text-center"
                                                    value="{{ old('cylinder_categories.' . $index . '.price', $existing->price ?? '') }}"
                                                    placeholder="Enter Price">

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
                                    Update
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
