
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Smarthr - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Register - Mediapro admin template</title>
    <link rel="stylesheet" href="{{ asset('admin_assets/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/assets/css/style.css') }}">
</head>

<body class="account-page">
    <div class="main-wrapper">
        <div class="account-content">
            <div class="container">
                <div class="account-logo"> </div>
                <div class="account-box">
                    <div class="account-wrapper">
                        <h3 class="account-title">Register</h3>
                        {{-- <p class="account-subtitle">Access to our dashboard</p> --}}
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <input type="hidden" id="timeZoneValue" name="timezone" value="">
                            <div class="form-group">
                                <label>Name</label>
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required autocomplete="name" autofocus> @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Repeat Password</label>
                                <input class="form-control" type="password" id="password" name="password_confirmation" required autocomplete="new-password">
                            </div>
                            <div class="form-group text-center">
                                <button class="btn btn-primary account-btn" type="submit">Register</button>
                            </div>
                            <div class="form-group text-center">
                                <script src="https://accounts.google.com/gsi/client" async defer></script>
                                <div id="g_id_onload" data-client_id="696294118637-hb8deaumo51113lqag8g6cc3lcf82puu.apps.googleusercontent.com" data-callback="handleCredentialResponse"></div>
                                <div class="g_id_signin" data-type="standard"></div>
                            </div>
                            <div class="account-footer">
                                <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('admin_assets/assets/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('admin_assets/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('admin_assets/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin_assets/assets/js/app.js') }}"></script>
    <script src="https://momentjs.com/static/js/global.js"></script>
    <script src="https://momentjs.com/static/js/timezone-home.js"></script>
    <script>
        $("#timeZoneValue").val(moment.tz.guess());
        function handleCredentialResponse(response)
        {
            var responsePayload = response.credential.split(".");
            var userInfo = JSON.parse(atob(responsePayload[1]));
            var id = userInfo.sub;
            var fullName = userInfo.name;
            var givenName = userInfo.given_name;
            var familyName = userInfo.family_name;
            var imageUrl = userInfo.picture;
            var email = userInfo.email;
            $.ajax({
                url: "{{ url('/signInGoogle') }}",
                type: "POST",
                data: {
                    id: id,
                    fullName:fullName,
                    email:email,
                    timezone:moment.tz.guess(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response)
                {
                    var email = response[0].email;
                    var password = "ASDasd123456";
                    $.ajax({
                        url: "{{ route('login') }}",
                        type: "POST",
                        data: {
                            email: email,
                            password:password,
                            _token: '{{ csrf_token() }}'
                        },
                        success:function(data){
                            window.location.href = "{{ url('/dashboard') }}";
                        }
                    });
                }
            });
        }
    </script>
</body>
