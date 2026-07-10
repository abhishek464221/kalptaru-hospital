@extends('admin.layouts.auth')

@section('title', 'Login')

@section('content')
<div class="account-page">
    <div class="account-center">
        <div class="account-box">
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="account-logo">
                    <a href="{{ route('admin.dashboard') }}"><img src="{{ asset('assets/img/logo-dark.png') }}" alt=""></a>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group text-right">
                    <a href="{{ route('password.request') }}">Forgot your password?</a>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary account-btn">Login</button>
                </div>
                <div class="text-center register-link">
                    Don’t have an account? <a href="{{ route('register') }}">Register Now</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
























