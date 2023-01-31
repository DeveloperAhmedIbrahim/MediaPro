<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="mediapro - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
    <meta name="author" content="mediapro - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Forgot Password - MediaPro</title>
    <link rel="stylesheet" href="{{ asset('admin_assets/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/assets/css/style.css') }}">
</head>

<body class="account-page">
    <div class="main-wrapper">
        <div class="account-content">
            <div class="container">
                <div class="account-box">
                    <div class="account-wrapper">
                        <h3 class="account-title">Reset</h3>
                        <p class="account-subtitle">Your MediaPro Password</p>
                        @if (!Session::has('googleAccount'))
                            <div>
                                <p style="color:gray;">Submit your email address and we’ll send you a link to reset your password.</p>
                                <form class="" action="{{ url('/verifyEmailForFP') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group text-center">
                                        <input type="submit" name="submit" value="SUBMIT" class="btn btn-primary account-btn">
                                    </div>
                                    <div class="account-footer">
                                        <p><a href="{{ url('login') }}">Go back</a></p>
                                    </div>
                                </form>
                                @if (Session::has('error'))
                                    <div class="alert alert-danger mt-4">{{ session('error') }}</div>
                                @endif
                                @if (Session::has('success'))
                                    <div class="alert alert-success mt-4">{{ session('success') }}</div>
                                @endif
                            </div>
                        @endif
                        @if (Session::has('googleAccount'))
                            <div>
                                <p style="color:gray;">You don't need a password! Your account was created via Google, click button below to sign in.</p>
                                <div class="form-group text-center">
                                    <script src="https://accounts.google.com/gsi/client" async defer></script>
                                    <div id="g_id_onload" data-client_id="696294118637-hb8deaumo51113lqag8g6cc3lcf82puu.apps.googleusercontent.com" data-callback="handleCredentialResponse"></div>
                                    <div class="g_id_signin" data-type="standard"></div>
                                </div>
                            </div>
                        @endif
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
        var timeZoneValue = moment.tz.guess();
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
                    timezone:timeZoneValue,
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

</html>
