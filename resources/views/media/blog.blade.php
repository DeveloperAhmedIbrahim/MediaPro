@extends('media.front.app')
@section('content')
   <!-- breadcrumb -->
   <div class="gen-breadcrumb" style="background-image: url({{asset('frontent_assets/images/background/asset-25.jpg')}});">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <nav aria-label="breadcrumb">
                        <div class="gen-breadcrumb-title">
                            <h1>
                                blog 
                            </h1>
                        </div>
                        <div class="gen-breadcrumb-container">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i
                                            class="fas fa-home mr-2"></i>Home</a></li>
                                <li class="breadcrumb-item active">blog</li>
                            </ol>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->

    <!-- blog single -->
  
   <section class="gen-section-padding-2">
    <div class="container">
       <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12">
             <h5 class="gen-heading-title text-center">Popular in our blog
             </h5>
          </div>

       </div>
       <div class="row mt-3 text-center">
          <div class="col-xl-12 col-md-12 order-1 order-xl-2">
             <div class="gen-blog gen-blog-col-1">
                 <div class="row">
                     <div class="col-lg-4">
                         <div class="gen-blog-post">
                             <div class="gen-post-media">
                                 <img src="{{asset('frontent_assets/images/background/asset-19.jpg')}}" alt="blog-image" loading="lazy">
                             </div>
                             <div class="gen-blog-contain">
                                 <div class="gen-post-meta">
                                    <ul>
                                         <li class="gen-post-author"><i class="fa fa-user"></i>admin</li>
                                         <li class="gen-post-meta"><a href="blog-single.html"><i class="fa fa-calendar"></i>January 25, 2021</a>
                                         </li>
   
                                     </ul>
                                 </div>
                                 <h6 class="gen-blog-title"><a href="blog-single.html">What is Live Linear TV Streaming and How to Create a Linear Channel</a></h6>
                                
                                 <div class="gen-btn-container">
                                     <a href="blog-single.html" class="gen-button">
                                         <div class="gen-button-block">
                                             <span class="gen-button-text">Read More</span>
                                         </div>
                                     </a>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="col-lg-4">
                         <div class="gen-blog-post">
                             <div class="gen-post-media">
                                 <img src="{{asset('frontent_assets/images/background/asset-2.jpg')}}" alt="blog-image" loading="lazy">
                             </div>
                             <div class="gen-blog-contain">
                                 <div class="gen-post-meta">
                                     <ul>
                                         <li class="gen-post-author"><i class="fa fa-user"></i>admin</li>
                                         <li class="gen-post-meta"><a href="blog-single.html"><i class="fa fa-calendar"></i>January 25, 2021</a>
                                         </li>

                                     </ul>
                                 </div>
                                 <h5 class="gen-blog-title"><a href="blog-single.html">How to Start Your Own Online Television Network – Guide</a></h5>

                                 <div class="gen-btn-container">
                                     <a href="blog-single.html" class="gen-button">
                                         <div class="gen-button-block">
                                             <span class="gen-button-text">Read More</span>
                                         </div>
                                     </a>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="col-lg-4">
                  
                     </div>
                    
                 </div>
           
             </div>
         </div>
       </div>
    </div>
 </section>

    <!-- blog single -->
@endsection