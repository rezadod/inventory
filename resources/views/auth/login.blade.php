<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>INVENTORY</title>
    <link rel="stylesheet" href="{{ asset('node_modules/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('node_modules/perfect-scrollbar/dist/css/perfect-scrollbar.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid">
            <div class="row">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center auth-pages">
                    <div class="card col-lg-4 mx-auto">
                        <div class="card-body">
                            <h3 class="card-title text-left mb-3">Login</h3>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="email"
                                        class="form-control p_input @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus
                                        placeholder="Email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password"
                                        class="form-control p_input @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="current-password" placeholder="Password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group d-flex align-items-center justify-content-between">
                                    <div class="form-check"><label><input type="checkbox" class="form-check-input"
                                                name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>Remember me</label></div>
                                    <!-- <a href="#" class="forgot-pass">Forgot password</a> -->
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-block enter-btn">LOGIN</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('node_modules/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{ asset('node_modules/popper.js/dist/umd/popper.min.js')}}"></script>
    <script src="{{ asset('node_modules/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('node_modules/perfect-scrollbar/dist/js/perfect-scrollbar.jquery.min.js')}}"></script>
    <script src="{{ asset('js/misc.js')}}"></script>
</body>

</html>