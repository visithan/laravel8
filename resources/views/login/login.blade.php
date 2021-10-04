@extends('layouts.loginlayout')
@section('title', 'Login')
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('login') }}"><b>My</b>Project</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                @if (strlen($errmsg) > 0)
                    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                        {{ $errmsg }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (session('message'))
                    <div class="alert alert-danger text-center">
                        <B>{{ session('message') }}</B>
                    </div>
                @endif
                <form action="" method="post" name="loginform">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="usrname" class="form-control @error('usrname') is-invalid @enderror" placeholder="User name"
                            value="{{ old('usrname') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @if ($errors->has('usrname'))
                            <div class="invalid-feedback">
                                {{ $errors->first('usrname') }}
                            </div>
                        @endif
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="passwd" class="form-control @error('passwd') is-invalid @enderror" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @if ($errors->has('passwd'))
                            <div class="invalid-feedback">
                                {{ $errors->first('passwd') }}
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <!--      <div class="social-auth-links text-center mb-3">-->
                <!--        <p>- OR -</p>-->
                <!--        <a href="#" class="btn btn-block btn-primary">-->
                <!--          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook-->
                <!--        </a>-->
                <!--        <a href="#" class="btn btn-block btn-danger">-->
                <!--          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+-->
                <!--        </a>-->
                <!--      </div>-->
                <!-- /.social-auth-links -->

                <p class="mb-1">
                    <a href="#">I forgot my password</a>
                </p>
                <p class="mb-0">
                    <a href="{{ route('register') }}" class="text-center">Register a new membership</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
@endsection
