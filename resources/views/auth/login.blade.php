@extends('layouts.auth')

@section('title', 'Login')

@section('main')
<div class="login-page position-relative pl-5">
    <div class="card rounded bg-gradient-blue">
        <div class="card-body login-card-body bg-gradient-blue">
            <img src="{{ asset('image/login.png') }}" alt="PUPR Logo" class="login-asset" />

            <div class="row login-box-msg">
                <div style="color: black">
                    <div class="d-flex mt-5 mb-4">
                        <img src="{{ asset('image/logo-pu-new.png') }}" alt="PUPR Logo" class="login-img" />
                        <div class="title-logo-pu">
                            <h2>PU-Net</h2>
                            <p>Dinas PUPR Kabupaten Tulang Bawang Baratt</p>
                        </div>
                    </div>
                    <h1 class="text-bold title-login">
                        Hi, <span class="text-yellow">Welcome Back!</span>
                    </h1>
                    <p class="fs-6 mb-4">{{ __('Please enter your email and password') }}</p>

                </div>
            </div>
            <form id="form-login" class="form-login" action="{{ route('login') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control rounded login-input @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" autofocus required autocomplete="false">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control rounded login-input @error('password') is-invalid @enderror" placeholder="Password" required>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-12 btn-action-right btn-forgot">
                        <a href="#" class="text-lightblue ">Forgot Password?</a>
                    </div>
                </div>
                <div class="btn-login mb-5">
                    <button type="submit" id="button-login" class="btn btn-warning btn-block rounded text-white text-bold d-flex justify-content-center">
                        <p id="text-login" class="p-0 m-0">{{ __('Login') }}</p>
                    </button>
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
@endsection
