
<!-- <header class="header_section">
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg custom_nav-container ">
        <a class="navbar-brand ml-5" href="index.html">
        <span> <img src="{{asset('admin_assets/assets/img/logo.png')}}" alt=""></span> -->
          <!-- <span>
            LOGO
          </span> -->
        <!-- </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
 -->
        <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <div class="d-flex mx-auto flex-column flex-lg-row align-items-center">
            <ul class="navbar-nav">
              <li class="nav-item active">
                <a class="nav-link" href="index.html"> <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
              </li>
              
              <li class="nav-item">
                <a class="nav-link" href="{{url('/about')}}"> Features</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{url('/about')}}"> Pricing </a>
              </li>
              <li class="nav-item">
                {{-- <a class="nav-link" id="navbar" href="contact.html" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Resources</a> --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Resources</a>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="#">Blog</a>
                      <a class="dropdown-item" href="#">Another action</a>
                    </div>
                  </li> -->
                <!-- <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Dropdown link
                </a> -->
<!--                
              </li>
            </ul>
          </div>
          <div class="quote_btn-container  d-flex justify-content-center">
            <a class="btn text-white mr-2" href="{{url('/login')}}"> -->
              <!-- <img src="images/call.png" alt=""> -->
              <!-- LOG IN
            </a>
            <a class="btn" href="{{url('/register')}}" style="background: #8c44f7; color:white">
              
              SIGN UP
            </a>
          </div>
        </div>
      </nav>
    </div>
  </header> -->
   
   
   <!--========== Header ==============-->
   <header id="gen-header" class="gen-header-style-1 gen-has-sticky">
      <div class="gen-bottom-header">
         <div class="container">
            <div class="row">
               <div class="col-lg-12">
                  <nav class="navbar navbar-expand-lg navbar-light">
                     <a class="navbar-brand" href="#">
                        <img class="img-fluid logo" src="{{asset('frontent_assets/images/favicon.png')}}" alt="streamlab-image">
                     </a>
                     <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div id="gen-menu-contain" class="gen-menu-contain">
                           <ul id="gen-main-menu" class="navbar-nav ml-auto">
                              <li class="menu-item">
                                 <a href="{{url('/features')}}" aria-current="page">Features</a>
                              </li>
                              <li class="menu-item">
                                 <a href="{{url('/pricing')}}">Pricing</a>
                              </li>
                              <li class="menu-item">
                                 <a href="#">Resources</a>
                                 <i class="fa fa-chevron-down gen-submenu-icon"></i>
                                 <ul class="sub-menu">
                                    <li class="menu-item menu-item-has-children">
                                       <a href="{{url('/blog')}}">Blog</a>
                                    </li>
                                    <li class="menu-item menu-item-has-children">
                                       <a href="#">Video Glossary</a>
                                    </li>
                                 </ul>
                              </li>
                              <li class="menu-item">
                                 <a href="{{url('/login')}}">Login</a>
                              </li>
                           </ul>
                        </div>
                     </div>
                     <div class="gen-header-info-box">
                        <div class="gen-btn-container">
                           <a href="{{url('/register')}}" class="gen-button">
                              <div class="gen-button-block">
                                 <span class="gen-button-line-left"></span>
                                 <span class="gen-button-text">Sign Up</span>
                              </div>
                           </a>
                        </div>
                     </div>
                     <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-bars"></i>
                     </button>
                  </nav>
               </div>
            </div>
         </div>
      </div>
   </header>
   <!--========== Header ==============-->