@extends('layouts.master')
@section('content')
    <!-- Page-content -->
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Profile</h4>
                    <h6>User Profile</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="profile-set">
                        <div class="profile-head">
                        </div>
                        <form action="{{route('profile.image.update')}}" enctype="multipart/form-data" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="profile-top">
                                <div class="profile-content">
                                    <div class="profile-contentimg">
                                        <img src="{{ isset($user->avatar) && $user->avatar
                                            ? asset('storage/' . $user->avatar)
                                            : asset('assets/img/profiles/avatar-02.jpg') }}"
                                            alt="img" id="blah" style="max-width:120px;">

                                        <div class="profileupload">
                                            <input type="file" id="imgInp" name="profile_image">

                                            <a href="javascript:void(0);">
                                                <img src="{{ asset('assets/img/icons/edit-5.svg') }}" alt="upload">
                                            </a>
                                        </div>
                                    </div>

                                    <div class="profile-contentname">
                                        <h2>{{ $user->name }}</h2>
                                        <h4>Updates Your Photo and Personal Details.</h4>
                                    </div>
                                </div>
                                <div class="ms-auto">
                                    <button type="submit" class="btn btn-submit me-2">Save</button>

                                    <a href="{{route('home')}}" class="btn btn-cancel">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                        placeholder="Enter your name">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" value="{{ old('email', $user->email) }}"
                                        placeholder="Enter your email">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Mobile</label>
                                    <input type="text" name="mobile" value="{{ old('mobile', $user->mobile) }}"
                                        placeholder="Enter your phone number">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Password</label>
                                    <div class="pass-group">
                                        <input type="password" name="password" class="pass-input">
                                        <span class="fas toggle-password fa-eye-slash"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                {{-- <a href="javascript:void(0);" class="btn btn-submit me-2">Submit</a> --}}
                                <button type="submit" class="btn btn-submit me-2">Submit</button>

                                <a href="{{route('home')}}" class="btn btn-cancel">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page-content -->
@section('script')
@endsection
@endsection
