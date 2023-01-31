
<!DOCTYPE html>
<html lang="en">


<head>
   <meta charset="utf-8">
   <meta name="keywords" content="Streamlab - Video Streaming HTML5 Template" />
   <meta name="description" content="Streamlab - Video Streaming HTML5 Template" />
   <meta name="author" content="StreamLab" />
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <title>Media Pro</title>
   <!-- Favicon -->
   @include('media.inc.style')
</head>

<body>

   <!--=========== Loader =============-->
   <div id="gen-loading">
      <div id="gen-loading-center">
         <img src="{{asset('frontent_assets/images/favicon.png')}}" alt="loading">
      </div>
   </div>
   <!--=========== Loader =============-->

@include('media.inc.header')
   <!-- owl-carousel Banner Start -->

   <!-- owl-carousel Banner End -->
@yield('content')

  <!-- footer start -->
 @include('media.inc.footer')
<!-- footer End -->

   <!-- Back-to-Top start -->
   <div id="back-to-top">
      <a class="top" id="top" href="#top"> <i class="ion-ios-arrow-up"></i> </a>
   </div>
   <!-- Back-to-Top end -->

@include('media.inc.script')
</body>

</html>