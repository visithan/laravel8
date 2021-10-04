@extends('layouts.loginlayout')
@section('title', 'Register')
@section('content')
    <div class="register-box">
        <div class="register-logo">
            <a href="{{ route('login') }}"><b>My</b>Project</a>
        </div>

        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Register a new membership</p>

                <form action="#" method="post" class="">
                    @csrf
                    @if (session('errmsg'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <b>Error: </b>{{ session('errmsg') }}
                        </div>
                    @endif
                    @if (session('succmsg'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <span style="text-align: justify"><B>Succcess: </B>{{ session('succmsg') }}</span>
                        </div>
                    @endif
                    <div class="input-group mb-3">
                        <input type="text" name="fname" class="form-control @error('fname') is-invalid @enderror"
                            placeholder="First name" value="{{ old('fname') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        @if ($errors->has('fname'))
                            <div class="invalid-feedback">
                                {{ $errors->first('fname') }}
                            </div>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="lname" class="form-control @error('lname') is-invalid @enderror"
                            placeholder="Last name" value="{{ old('lname') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        @if ($errors->has('lname'))
                            <div class="invalid-feedback">
                                {{ $errors->first('lname') }}
                            </div>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Email" value="{{ old('email') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @if ($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="uname" class="form-control @error('uname') is-invalid @enderror"
                            placeholder="User name" value="{{ old('uname') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        @if ($errors->has('uname'))
                            <div class="invalid-feedback">
                                {{ $errors->first('uname') }}
                            </div>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="pass1" class="form-control @error('pass1') is-invalid @enderror"
                            placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @if ($errors->has('pass1'))
                            <div class="invalid-feedback">
                                {{ $errors->first('pass1') }}
                            </div>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="pass2" class="form-control @error('pass2') is-invalid @enderror"
                            placeholder="Retype password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @if ($errors->has('pass2'))
                            <div class="invalid-feedback">
                                {{ $errors->first('pass2') }}
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary @error('terms') is-invalid @enderror">
                                <input type="checkbox" id="terms" name="terms" value="agree" required>
                                <label for="terms">
                                    I agree to the <a href="#">terms</a>
                                </label>
                            </div>
                            @if ($errors->has('terms'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('terms') }}
                                </div>
                            @endif
                        </div>
                        <!-- /.col -->
                        <div class="col-4 ">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <!--      <div class="social-auth-links text-center">-->
                <!--        <p>- OR -</p>-->
                <!--        <a href="#" class="btn btn-block btn-primary">-->
                <!--          <i class="fab fa-facebook mr-2"></i>-->
                <!--          Sign up using Facebook-->
                <!--        </a>-->
                <!--        <a href="#" class="btn btn-block btn-danger">-->
                <!--          <i class="fab fa-google-plus mr-2"></i>-->
                <!--          Sign up using Google+-->
                <!--        </a>-->
                <!--      </div>-->

                <a href="{{ route('login') }}" class="text-center">I already have a membership</a>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

@endsection
