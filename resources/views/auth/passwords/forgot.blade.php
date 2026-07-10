@extends('admin.layouts.auth')

@section('title', 'Forgot Password')

@section('content')
<div class="account-page">
    <div class="account-center">
        <div class="account-box">
            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="account-logo">
                    <a href="{{ route('admin.dashboard') }}"><img src="{{ asset('assets/img/logo-dark.png') }}" alt=""></a>
                </div>
                <div class="form-group">
                    <label>Enter Your Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    @if(session('status'))
                        <div class="text-success">{{ session('status') }}</div>
                    @endif
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-primary account-btn" type="submit">Reset Password</button>
                </div>
                <div class="text-center register-link">
                    <a href="{{ route('login') }}">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection