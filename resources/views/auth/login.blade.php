@extends('layouts.auth')

@section('content')
    <div class="col-lg-4 col-md-8 col-10 box-shadow-2 p-0">
        <div class="card border-grey border-lighten-3 m-0">
            <div class="card-header border-0">
                <div class="card-title text-center">
                    <div class="p-1"><img src="{{asset('images/logo.png')}}"
                                          alt="logo"></div>
                </div>
                <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span>Login with
                            {{config('app.name')}}</span></h6>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form method="POST" class="form-horizontal form-simple" action="{{ route('login') }}">
                        @csrf
                        <fieldset class="form-group position-relative has-icon-left mb-0">
                            <input type="email"
                                   class="form-control form-control-lg @error('email') is-invalid @enderror" name="email"
                                   placeholder="Your Email" required autocomplete="email" autofocus>
                            <div class="form-control-position">
                                <i class="feather icon-user"></i>
                            </div>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </fieldset>
                        <fieldset class="form-group position-relative has-icon-left">
                            <input type="password"
                                   class="form-control form-control-lg @error('password') is-invalid @enderror"
                                   id="password" name="password"
                                   placeholder="Enter Password" required autocomplete="current-password">
                            <div class="form-control-position">
                                <i class="fa fa-key"></i>
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </fieldset>
                        <div class="form-group row">
                            <div class="col-sm-6 col-12 text-center text-sm-left">
                                <fieldset>
                                    <input type="checkbox" id="remember" name="remember"
                                           class="chk-remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember"> Remember Me</label>
                                </fieldset>
                            </div>
                            @if (Route::has('password.request'))
                                <div class="col-sm-6 col-12 text-center text-sm-right"><a
                                        href="{{ route('password.request') }}"
                                        class="card-link">Forgot Password?</a></div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg btn-block"><i
                                class="feather icon-unlock"></i> Login
                        </button>
                    </form>
                </div>
            </div>
            @if (Route::has('register'))
                <div class="card-footer">
                    <div class="">
                        <p class="float-sm-left text-center m-0"></p>
                        <p class="float-sm-right text-center m-0">New to {{config('app.name')}}? <a
                                href="{{ route('register') }}"
                                class="card-link">Sign Up</a></p>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
