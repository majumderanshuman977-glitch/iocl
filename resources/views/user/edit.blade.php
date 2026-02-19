@extends('layouts.master')
@section('content')

<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>User Management</h4>
                <h6>Update User</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('user.update', $user->id) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <!-- Left column -->
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name"
                                       class="form-control"
                                       value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email"
                                       class="form-control"
                                       value="{{ old('email', $user->email) }}">
                            </div>

                            <div class="form-group">
                                <label>Password (leave blank to keep)</label>
                                <div class="pass-group">
                                    <input type="password"
                                           name="password"
                                           class="pass-input form-control">
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Middle column -->
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Mobile</label>
                                <input type="text" name="mobile"
                                       class="form-control"
                                       value="{{ old('mobile', $user->mobile) }}" required>
                            </div>

                            <div class="form-group">
                                <label>Role</label>
                                <select class="form-control" name="roles[]" required>
                                    @foreach($role as $r)
                                        <option value="{{ $r->name }}"
                                            @if(in_array($r->name,
                                                old('roles', $user->getRoleNames()->toArray())))
                                                selected
                                            @endif>
                                            {{ Str::title(str_replace('_', ' ', $r->name)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Confirm Password</label>
                                <div class="pass-group">
                                    <input type="password"
                                           name="password_confirmation"
                                           class="pass-input form-control">
                                    <span class="fas toggle-passworda fa-eye-slash"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Image column -->
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Profile Picture</label>

                                <div class="image-upload image-upload-new">
                                    <input type="file"
                                           name="profile_image"
                                           id="imageInput"
                                           accept="image/*">

                                    <div class="image-uploads">
                                        <img id="previewImage"
                                             src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('assets/img/profiles/avatar-02.jpg') }}"
                                             style="max-width:120px; margin-bottom:10px;">
                                        <h4>Click or drag image to upload</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-submit me-2">
                                Update
                            </button>
                            <a href="{{ route('user/list') }}" class="btn btn-cancel">
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
