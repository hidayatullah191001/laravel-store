@extends('layouts.auth')

@section('title')
    Store Login Page
@endsection

@section('content')
    <div class="page-content page-auth">
        <div class="section-store-auth" data-aos="fade-up">
            <div class="container">
                <div class="row align-items-center row-login">
                    <div class="col-lg-6 text-center">
                        <img src="/images/login-placeholder.png" alt="" class="w-50 mb-6 mb-lg-none" />
                    </div>
                    <div class="col-lg-5">
                        @if (session()->has('success'))
                            <div class="alert alert-success w-75" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <h2>Belanja kebutuhan utama,<br />
                            menjadi lebih mudah</h2>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label>Email Address</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror w-75" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror w-75" name="password"
                                    required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success btn-block w-75 mt-4">Sign In to My
                                Account</button>
                            <a href="{{ route('register') }}" class="btn btn-light btn-block w-75 mt-4">Sign Up</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
