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
                            Affiliates
                            </h1>
                        </div>
                        <div class="gen-breadcrumb-container">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i
                                            class="fas fa-home mr-2"></i>Home</a></li>
                                <li class="breadcrumb-item active"> Affiliates</li>
                            </ol>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->


    <!-- Partners Section-1 Start -->
    <section class="pt-3 pb-0">
      <div class="container">
         <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
               <h5 class="gen-heading-title text-center">Join the MediaPro Affiliate Program
               </h5>
               <h6 class="gen-heading-title text-center">And earn money every month by referring clients.

               </h6>
               
            </div>
       <div class="container pt-2 pb-5 text-center">
         <div class="gen-btn-container">
            <a href="{{url('/register')}}" class="gen-button">
                <div class="gen-button-block">
                    <span class="gen-button-text">Join the Program</span>
                </div>
            </a>
        </div>
       </div>
         </div>
   
      </div>
   </section>
   <!-- Partners Section-1 End -->
   <!-- Partners Section-1 Start -->
   <section class="pt-3 pb-0">
      <div class="container">
         <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
               <h5 class="gen-heading-title text-center">Why Do Our Customers Love MediaPro?

               </h5>
            </div>
       <div class="container pt-2 pb-5 text-center">
<p>MediaPro is a powerful video platform that is used by small and medium sized brands to engage their audience without the need for technical knowledge.

</p>
       </div>
         </div>
   
      </div>
   </section>
   <!-- Partners Section-1 End -->

      <!-- Partners Section-1 Start -->
      <section class="pt-3 pb-0">
         <div class="container">
            <div class="row">
               <div class="col-xl-12 col-lg-12 col-md-12">
                  <h5 class="gen-heading-title text-center">Earn a 30% Recurring Commission   
                  </h5>
               </div>
          <div class="container pb-5">
   <p>As a MediaPro affiliate you’ll earn a 30% commission each month or year from everyone you refer. For instance, you get $297 per month ($3564 per year) for 10 Business Monthly clients. 
   </p>
   <ul>
      <li>Minimum balance required for payout is $50.</li>
      <li>Payments are made via Paypal once per month, for the previous month.
      </li>
   </ul>
          </div>
            </div>
      
         </div>
      </section>
      <!-- Partners Section-1 End -->

          <!-- Partners Section-1 Start -->
          <section class="pt-3 pb-0">
            <div class="container">
               <div class="row">
                  <div class="col-xl-12 col-lg-12 col-md-12">
                     <h5 class="gen-heading-title text-center">How To Join Our Program
                     </h5>
                     <p class="text-center">Joining the program is very simple and fast.
                     </p>
                  </div>
             <div class="container pb-5">
 
      <ol>
         <li>Click the button below to sign up through our affiliate program. You’ll instantly log into your account and will get a tracking link.
         </li>
         <li>Share this link on your blog, website, social media or using word of mouth.
         </li>
         <li>Each time a referred signup pay for MediaPro, you get 30% on every single one of their ongoing payment. You’ll see all the activity reflected in your account.</li>
      </ol>
      <div class="container pt-2 pb-5 text-center">
         <div class="gen-btn-container">
            <a href="{{url('/register')}}" class="gen-button">
                <div class="gen-button-block">
                    <span class="gen-button-text">Join the Program</span>
                </div>
            </a>
        </div>
       </div>
             </div>
               </div>
         
            </div>
         </section>
         <!-- Partners Section-1 End -->
@endsection