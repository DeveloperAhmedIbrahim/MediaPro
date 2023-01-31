<?php

    if(isset($_GET['token']))
    {
        $token = $_GET['token'];
    }
    if(isset($_GET['mail']))
    {
        $mail = $_GET['mail'];
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="mediapro - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
    <meta name="author" content="mediapro - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Reset Password - MediaPro</title>
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
                        <p style="color:gray;"></p>
                        <form class="" action="{{ url('/passwordChange') }}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="email" value="{{ $mail }}">
                            <div class="form-group">
                                <input id="password" type="password" class="form-control" name="password"  placeholder="Password" required  autofocus>
                            </div>
                            <div class="form-group">
                                <input id="passwordConfirm" type="password" class="form-control" name="passwordConfirm" placeholder="Confirm Password" required autofocus>
                            </div>
                            <div class="form-group text-center">
                                <input type="submit" name="submit" value="SUBMIT" class="btn btn-primary account-btn" id="btnResetPassword">
                            </div>
                            <div>
                                <span class="text-danger" id="matchError"></span>
                            </div>
                        </form>
                        @if (Session::has('error'))
                            <div class="alert alert-danger mt-4">{{ session('error') }}</div>
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
    <!--<script src="https://momentjs.com/static/js/timezone-home.js"></script>-->

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

        $("#btnResetPassword").click(function(){
            var password = $("#password").val();
            var passwordConfirm = $("#passwordConfirm").val();
            if(password != passwordConfirm)
            {
                $("#matchError").html("Passwords did not match.");
                return false;
            }
            else
            {
                $("#matchError").html("");
            }

        });
    </script>
</body>

</html>
