@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('auth.login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('auth.email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('auth.password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('auth.remember_me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('auth.login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('auth.forgot_password') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                        <div class="col-lg-12" style="margin-top: 50px;">
                            <h6 class="text-center">{{ trans('general.vault_text') }}</h6>
                            <table class="table">
                                <tr>
                                    <td>User Role</td>
                                    <td>Email</td>
                                    <td>Password</td>
                                </tr>
                                <tr>
                                    <td>Admin</td>
                                    <td>admin@abc.com</td>
                                    <td><i>12345678</i></td>
                                </tr>
                                <tr>
                                    <td>Sales Manager</td>
                                    <td>sales@abc.com</td>
                                    <td><i>12345678</i></td>
                                </tr>
                                <tr>
                                    <td>Operations Manager</td>
                                    <td>operations@abc.com</td>
                                    <td><i>12345678</i></td>
                                </tr>
                                <tr>
                                    <td>Customer</td>
                                    <td>customer@abc.com</td>
                                    <td><i>12345678</i></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
