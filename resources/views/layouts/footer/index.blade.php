<!-- Footer Start -->
<footer class="main-footer">
   <div class="container">
      <div class="row">
         <div class="col-lg-4 col-md-6">
            <!-- About Footer Start -->
            <div class="about-footer">
               <!-- Footer Logo Start -->
               <div class="footer-logo">
                  <img width="160px" src="{{url(''.$setting->logo_footer)}}" alt="{{$setting->logo_footer}}">
               </div>
               <!-- Footer Logo End -->
               <!-- About Footer Content Start -->
               <div class="about-footer-content">
                  <p>{!!($setting->company)!!}</p>
               </div>
               <!-- About Footer Content End -->
               <!-- Footer Social Link Start -->
               <div class="footer-contact-box footer-links">
                  <!-- Footer Contact Item Start -->
                  <div class="footer-contact-item">
                     <div class="icon-box">
                        <img src="/frontend/images/icon-mail.svg" alt="">
                     </div>
                     <div class="footer-contact-content">
                        <p>{{$setting->email}}</p>
                     </div>
                  </div>
                  <!-- Footer Contact Item End -->
                  <!-- Footer Contact Item Start -->
                  <div class="footer-contact-item">
                     <div class="icon-box">
                        <img src="/frontend/images/icon-phone.svg" alt="">
                     </div>
                     <div class="footer-contact-content">
                        <p>{{$setting->phone1}}</p>
                     </div>
                  </div>
                  <!-- Footer Contact Item End -->
                  <!-- Footer Contact Item Start -->
                  <div class="footer-contact-item">
                     <div class="icon-box">
                        <img src="/frontend/images/icon-location.svg" alt="">
                     </div>
                     <div class="footer-contact-content">
                        <p>{{$setting->address1}}</p>
                     </div>
                  </div>
                  <!-- Footer Contact Item End -->
               </div>
               <!-- Footer Social Link End -->
            </div>
            <!-- About Footer End -->
         </div>
         <div class="col-lg-4 col-md-6">
            <!-- Footer Links Start -->
            <div class="footer-links">
               <h3>Chính sách và quy định</h3>
               <ul>
                  @foreach ($pageContent as $item)
                  <li><a href="{{route('pagecontent',['slug'=>$item->slug])}}">{{($item->title)}}</a></li>
                  @endforeach
               </ul>
            </div>
            <!-- Footer Links End -->
         </div>
         <div class="col-lg-4 col-md-6">
            <!-- Footer Newsletter Box Start -->
            <div class="footer-newsletter-box footer-links">
               <h3>Vị trí</h3>
               <!-- Newsletter Form start -->
              {!!($setting->iframe_map)!!}
               <!-- Newsletter Form end -->
            </div>
            <!-- Footer Newsletter Box End -->
         </div>
      </div>
      <!-- Footer Copyright Section Start -->
      <div class="footer-copyright">
         <div class="row align-items-center">
            <div class="col-lg-12">
               <!-- Footer Copyright Start -->
               <div class="footer-copyright-text">
                  <p>Copyright © {{date('Y')}} All Rights Reserved.</p>
               </div>
               <!-- Footer Copyright End -->
            </div>
         </div>
      </div>
      <!-- Footer Copyright Section End -->
   </div>
</footer>
<!-- Footer End -->