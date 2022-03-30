@extends('app')
@section('content')
    <main class="login-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="card">
                        <h3 class="card-header text-center">Login</h3>
                        <div class="card-body">
                            <form method="POST" action="/api/login">
                                @csrf
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Email" id="email" class="form-control" name="email"
                                           required
                                           autofocus>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <input type="password" placeholder="Password" id="password" class="form-control"
                                           name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" id="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>

                            </form>
                            <div class="d-grid mx-auto">
                                <button id="submit" onclick="loginByForm(this);" class="btn btn-dark btn-block">Sign in</button>
                            </div>
                            Don't have an account? <a href="{{ route("register") }}">Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
