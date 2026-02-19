@extends('layouts.app')
@section('content')
    <div class="login-wrapper">
        <div class="login-img">
            <img src="{{ asset('assets/img/login.jpg') }}" alt="img">
        </div>
        <div class="login-content">
            <div class="login-userset">
                {{-- <div class="login-logo">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="img">
                </div> --}}
                <div class="login-userheading">
                    <h3>Sign In</h3>
                    <h4>Please login to your account</h4>
                </div>
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-login">
                        <label>Mobile Number</label>
                        <div class="form-addons">
                            <input type="text" name="mobile" placeholder="Enter your mobile number" required>
                            {{-- <img src="{{ asset('assets/img/icons/phone.svg') }}" alt="img"> --}}
                        </div>
                    </div>
                    <div class="form-login">
                        <label>Password</label>
                        <div class="pass-group">
                            <input type="password" class="pass-input" name="password" placeholder="Enter your password" required>
                            <span class="fas toggle-password fa-eye-slash"></span>
                        </div>
                    </div>
                    {{-- <div class="form-login">
                        <div class="alreadyuser">
                            <h4><a href="forgetpassword.html" class="hover-a">Forgot Password?</a></h4>
                        </div>
                    </div> --}}
                    <div class="form-login">
                        <button type="submit" class="btn btn-login">Sign In</button>
                    </div>
                </form>
                {{-- <div class="signinform text-center">
                    <h4>Don’t have an account? <a href="{{ route('register') }}" class="hover-a">Sign Up</a></h4>
                </div> --}}
                {{-- <div class="form-setlogin">
                    <h4>Or sign up with</h4>
                </div> --}}
                {{-- <div class="form-sociallink">
                    <ul>
                        <li>
                            <a href="javascript:void(0);">
                                <img src="{{ asset('assets/img/icons/google.png') }}" class="me-2" alt="google">
                                Sign Up using Google
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <img src="{{ asset('assets/img/icons/facebook.png') }}" class="me-2" alt="google">
                                Sign Up using Facebook
                            </a>
                        </li>
                    </ul>
                </div> --}}
            </div>
        </div>
    </div>
@endsection

