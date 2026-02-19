@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Super Admin Management</h4>
                    <h6>Add Super Admin</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <!-- Left column -->
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="text" name="email" class="form-control" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Password <span class="text-danger">*</span></label>
                                    <div class="pass-group">
                                        <input type="password" name="password" class="pass-input form-control" required>
                                        <span class="fas toggle-password fa-eye-slash"></span>
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Middle column -->
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Mobile</label>
                                    <input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}">
                                    @error('mobile')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <input type="hidden" name="roles[]" value="super_admin">

                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <div class="pass-group">
                                        <input type="password" name="password_confirmation" class="pass-input form-control">
                                        <span class="fas toggle-passworda fa-eye-slash"></span>
                                        @error('password_confirmation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Image column -->
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Profile Picture</label>

                                    <div class="image-upload image-upload-new">
                                        <input type="file" name="profile_image" id="imageInput" accept="image/*">

                                        <div class="image-uploads">
                                            <img id="previewImage" src=""
                                                style="max-width:120px; margin-bottom:10px;">
                                            <h4>Click or drag image to upload</h4>
                                        </div>
                                        @error('profile_image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">
                                    Submit
                                </button>
                                <a href="{{ route('user.superadmin') }}" class="btn btn-cancel">
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
            let reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('previewImage').src = event.target.result;
            };
            reader.readAsDataURL(e.target.files[0]);
        });
    </script>
@endsection
