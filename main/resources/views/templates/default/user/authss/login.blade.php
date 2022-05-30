@extends($activeTemplate . 'user.layouts.master')


@section('content')
    {{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user.login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
    <!-- main-signin-wrapper -->
    <div class="my-auto page page-h">
        <div class="main-signin-wrapper">
            <div class="main-card-signin d-md-flex wd-100p">
                <div class="wd-md-40p login d-none d-md-block page-signin-style p-5 text-white">
                    {{-- <div class="my-auto authentication-pages"> --}}
                    <div class="side-left">
                        {{-- <img src="{{  asset('assets/img/brand/logo-white.png') }}" class="m-0 mb-4" alt="logo"> --}}
                        <h4 class="mb-4">Welcome to MLM World</h4>
                        <p class="mb-2">Don't have an account <br> Create an Account?</p>
                        <a href="{{ route('user.register') }}" class="btn btn-danger">Register</a>
                    </div>
                    {{-- </div> --}}
                </div>
                <div class="p-5 wd-md-60p">
                    <div class="main-signin-header">
                        <h2>Welcome back!</h2>
                        <h4>Please sign in to continue</h4>
                        <form method="POST" action="{{ route('user.login') }}">
                            @csrf

                            <div class="form-group">
                                <label>Username</label>
                                <input class="form-control" name="username" placeholder="Enter your username"
                                    value="{{ old('username') }}" type="text">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input class="form-control" name="password" placeholder="Enter your password"
                                    type="password" required autocomplete="current-password">
                            </div>

                            <button type="submit" class="btn btn-main-primary btn-block">
                                {{ __('Login') }}
                            </button>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-6">

                                    @if (Route::has('user.password.request'))
                                        <a class="btn btn-link" href="{{ route('user.password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- /main-signin-wrapper -->
@endsection


@push('script')
    <script>
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML =
                    '<span class="text-danger">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }

        function verifyCaptcha() {
            document.getElementById('g-recaptcha-error').innerHTML = '';
        }
    </script>
@endpush
