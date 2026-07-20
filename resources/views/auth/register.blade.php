@extends('admin.layouts.auth')

@section('title', 'Register')

@section('content')
<div class="account-page">
    <div class="account-center">
        <div class="account-box">
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="account-logo">
                    <a href="{{ route('admin.dashboard') }}">
                        {{-- Dynamic logo --}}
                        @php
                            $logo = \App\Models\Setting::get('logo_header');
                        @endphp
                        @if($logo)
                            <img src="{{ asset('storage/' . $logo) }}" alt="Company Logo">
                        @else
                            <img src="{{ asset('assets/img/logo-dark.png') }}" alt="Default Logo">
                        @endif
                    </a>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <div class="form-group checkbox">
                    <label>
                        <input type="checkbox" name="terms" required> I have read and agree the <strong>Terms & Conditions</strong>
                    </label>
                    @error('terms') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-primary account-btn" type="submit">Signup</button>
                </div>
                <div class="text-center login-link">
                    Already have an account? <a href="{{ route('login') }}">Login</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection