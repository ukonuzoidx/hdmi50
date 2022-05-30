@extends('admin.layouts.master')

@section('content')
    <!-- main-signin-wrapper -->
    <div class="my-auto page page-h">
        <div class="main-signin-wrapper">
            <div class="main-card-signin d-md-flex wd-100p">

                <div class="p-5 wd-md-100p">
                    <div class="main-signin-header">
                        <h2 class="text-center">Welcome to the Admin Panel!</h2>
                        <h4 class="text-center">Please sign in to continue</h4>
                        <form method="POST" action="{{ route('admin.post.login') }}">
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
