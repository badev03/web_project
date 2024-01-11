


@extends('clients.layouts.master')
@section('content')
    <!-- customer login start -->
    <div class="customer_login">
        <div class="container">
            <div class="row">
        
                <!--register area end-->
                <div class="col-lg-6 col-md-6">
                    <div class="account_form">
                        <h2>Đăng kí</h2>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <p>
                                <label for="name">Họ và tên<span>*</span></label>
                                {{-- <input type="text" name="email" id="email"  class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus"> --}}
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </p>
                            <p>
                                <label for="email-r">Email<span>*</span></label>
                                {{-- <input type="text" name="email" id="email"  class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus"> --}}
                                <input id="email-r" type="text" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </p>
                            <p>
                                <label for="phone">phone</label>
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" value="{{ old('phone') }}" autocomplete="phone" autofocus>

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </p>
                            <p>
                                <label for="password">Mật khẩu <span>*</span></label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    autocomplete="current-password" value="{{old('password')}}">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </p>
                            <p>
                                <label for="password-c"> Nhập lại mật khẩu <span>*</span></label>
                                <input id="password-c" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password-confirm"
                                    autocomplete="current-password">
                                @error('password-confirm')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </p>
                            <div class="login_submit">
                                <a href="{{route('login')}}">Đăng nhập</a>
                             
                                <button type="submit">Đăng kí</button>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@php
    $headershop = true;
@endphp
