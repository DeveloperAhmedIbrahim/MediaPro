<div class="header">
			
         <!-- Logo -->
             <div class="header-left">
                 <a href="index.html" class="logo">
               <!-- <img src="{{asset('admin_assets/assets/img/logo.png')}}" width="40" height="40" alt=""> -->
            </a>
             </div>
         <!-- /Logo -->
         
         <a id="toggle_btn" href="javascript:void(0);">
            <span class="bar-icon">
               <span></span>
               <span></span>
               <span></span>
            </span>
         </a>
         
         <!-- Header Title -->
             <div class="page-title-box">
            <h3>  You have 4 days left in your trial</h3>

             </div>
         <!-- /Header Title -->
         
         <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>
         
         <!-- Header Menu -->
         <ul class="nav user-menu">
         
            <!-- Search -->
            <li class="nav-item">
               <div class="top-nav-search">
                  <a href="javascript:void(0);" class="responsive-search">
                     <i class="fa fa-search"></i>
                  </a>
                  <form action="search.html">
                     <input class="form-control" type="text" placeholder="Search here">
                     <button class="btn" type="submit"><i class="fa fa-search"></i></button>
                  </form>
               </div>
            </li>
            <!-- /Search -->
         
            <!-- Flag -->
            <li class="nav-item dropdown has-arrow flag-nav">
               <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">
                  <img src="{{asset('admin_assets/assets/img/flags/us.png')}}" alt="" height="20"> <span>English</span>
               </a>
               <div class="dropdown-menu dropdown-menu-right">
                  <a href="javascript:void(0);" class="dropdown-item">
                     <img src="{{asset('admin_assets/assets/img/flags/us.png')}}" alt="" height="16"> English
                  </a>
            
                  <a href="javascript:void(0);" class="dropdown-item">
                     <img src="{{asset('admin_assets/assets/img/flags/es.png')}}" alt="" height="16"> Spanish
                  </a>
                 
               </div>
            </li>
            <!-- /Flag -->
         
          

            <li class="nav-item dropdown has-arrow main-drop">
               <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                  <span class="user-img"><img src="{{asset('admin_assets/assets/img/profiles/avatar-21.jpg')}}" alt="">
                  <span class="status online"></span></span>
                  <span>{{Auth::user()->name}}</span>
               </a>
               <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{url('profile')}}">My Profile</a>

                  <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="icon-logout"></i> Logout</a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
               </div>
            </li>
         </ul>
         <!-- /Header Menu -->
         
         <!-- Mobile Menu -->
         <div class="dropdown mobile-user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
               <a class="dropdown-item" href="profile.html">My Profile</a>
               <a class="dropdown-item" href="settings.html">Settings</a>
               <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="icon-logout"></i> Logout</a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
            </div>
         </div>
         <!-- /Mobile Menu -->
         
         </div>
