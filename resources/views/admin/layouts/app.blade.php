<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Smarthr - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Dashboard - HRMS admin template</title>
    @include('admin.inc.style')

</head>

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">

        @include('admin.inc.navbar')
        <!-- Side-Nav-->
        @include('admin.inc.sidebar')
        <!-- Sidebar chat start -->
        <!-- Page Wrapper -->
        <div class="page-wrapper">

            @yield('content')

        </div>
        <!-- /Page Wrapper -->

    </div>
    <!-- /Main Wrapper -->


    <!-- Required Jqurey -->
    @include('admin.inc.scripit')

</body>

</html>
