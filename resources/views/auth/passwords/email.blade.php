@extends('layouts.auth')

@section('content')
    <div class="col-lg-4 col-md-8 col-10 box-shadow-2 p-0">
        <div class="card border-grey border-lighten-3 px-2 py-2 m-0">
            <div class="card-header border-0 pb-0">
                <div class="card-title text-center">
                    <img src="{{asset('images/logo.png')}}"
                         alt="logo">
                </div>
                <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span>We will send
                            you a link to reset password.</span></h6>
            </div>
            <div class="card-content">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" class="form-horizontal" action="{{ route('password.email') }}">
                        @csrf
                        <fieldset class="form-group position-relative has-icon-left">
                            <input id="email" type="email"
                                   class="form-control form-control-lg @error('email') is-invalid @enderror"
                                   name="email"
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
                        <button type="submit" class="btn btn-outline-primary btn-lg btn-block"><i
                                class="feather icon-unlock"></i> Recover Password</button>
                    </form>
                </div>
            </div>
            <div class="card-footer border-0">
                <p class="float-sm-left text-center"><a href="{{ route('login') }}" class="card-link">Login</a></p>
                <p class="float-sm-right text-center">New to {{ config('app.name') }} ? <a href="{{ route('register') }}"
                                                                        class="card-link">Create Account</a></p>
            </div>
        </div>
    </div>
@endsection
