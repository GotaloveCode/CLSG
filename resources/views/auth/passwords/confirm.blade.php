@extends('layouts.auth')

@section('content')
    <div class="col-lg-4 col-md-8 col-10 box-shadow-2 p-0">
        <div class="row justify-content-center">
            <div class="card border-grey border-lighten-3 m-0">
                <div class="card-header border-0">
                    <div class="card-title text-center">
                        <div class="p-1"><img src="{{asset('images/logo.png')}}"
                                              alt="logo"></div>
                    </div>
                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                        <span>Confirm Password</span></h6>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        {{ __('Please confirm your password before continuing.') }}

                        <form method="POST" class="form-horizontal form-simple"
                              action="{{ route('password.confirm') }}">
                            @csrf
                            <fieldset class="form-group position-relative has-icon-left mb-1">
                                <input type="password"
                                       class="form-control form-control-lg @error('password') is-invalid @enderror"
                                       id="password" name="password"
                                       placeholder="Enter Password" required autocomplete="new-password">
                                <div class="form-control-position">
                                    <i class="fa fa-key"></i>
                                </div>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </fieldset>
                            <button type="submit" class="btn btn-primary btn-lg btn-block"><i
                                    class="feather icon-unlock"></i> Confirm Password
                            </button>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @if (Route::has('password.request'))
                    <p class="text-center"><a href="{{ route('password.request') }}" class="card-link">Forgot
                            Password?</a></p>
                @endif
            </div>
        </div>
    </div>
@endsection
