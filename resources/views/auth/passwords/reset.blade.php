@extends('layouts.auth')

@section('content')
    <div class="col-lg-4 col-md-8 col-10 box-shadow-2 p-0">
        <div class="card border-grey border-lighten-3 m-0">
            <div class="card-header border-0">
                <div class="card-title text-center">
                    <div class="p-1"><img src="{{asset('images/logo.png')}}"
                                          alt="logo"></div>
                </div>
                <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                    <span>Reset Password</span></h6>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form method="POST" class="form-horizontal form-simple" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">
                        <fieldset class="form-group position-relative has-icon-left">
                            <input id="email" type="email"
                                   class="form-control form-control-lg @error('email') is-invalid @enderror"
                                   name="email" value="{{ $email ?? old('email') }}"
                                   placeholder="Your Email Address" required autocomplete="email" autofocus>
                            <div class="form-control-position">
                                <i class="feather icon-mail"></i>
                            </div>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </fieldset>
                        <fieldset class="form-group position-relative has-icon-left mb-1">
                            <input type="password"
                                   class="form-control form-control-lg @error('password') is-invalid @enderror"
                                   id="password" name="password"
                                   placeholder="Enter Password" required autocomplete="new-password">
                            <div class="form-control-position">
                                <i class="feather icon-key"></i>
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </fieldset>
                        <fieldset class="form-group position-relative has-icon-left">
                            <input type="password"
                                   class="form-control form-control-lg"
                                   id="password-confirm" name="password_confirmation"
                                   placeholder="Confirm Password" required autocomplete="new-password">
                            <div class="form-control-position">
                                <i class="feather icon-key"></i>
                            </div>
                        </fieldset>
                        <button type="submit" class="btn btn-primary btn-lg btn-block"><i
                                class="feather icon-unlock"></i> Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
