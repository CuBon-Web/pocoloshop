<!DOCTYPE html>
<html lang="zxx">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Thẻ Bảo Hành Pocolo</title>
      <meta name="robots" content="noindex, follow" />
      <meta name="description" content="">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- Favicon -->
      <link rel="shortcut icon" type="image/x-icon" href="/frontend/images/logo.png" />
      
      <link rel="stylesheet" href="/frontend/css/vendor.min.css">
      <link rel="stylesheet" href="/frontend/css/plugins.min.css">
      <link rel="stylesheet" href="/frontend/css/style.min.css">
      @yield('css')
      <style>
         .hero-content .title-big,
         .hero-content .title-large,
         .hero-content .title-large .shape-mark {
            background: linear-gradient(90deg, #e2b441, #ffd700, #ffec8b);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
         }
      </style>
   </head>
   <body>
      <main class="main-wrapper">
         <!-- .....:::::: Start Header Section :::::.... -->
         <header class="header-section sticky-header d-none d-lg-block">
            <div class="header-wrapper">
               <div class="container">
                  <div class="row justify-content-between align-items-center">
                     <div class="col text-center">
                        <!-- Start Header Logo -->
                        <a href="" class="header-logo">
                        <img width="250" src="/frontend/images/logo.png" alt="">
                        </a>
                        <!-- End Header Logo -->
                     </div>
                  </div>
               </div>
            </div>
         </header>
         <!-- .....:::::: End Header Section :::::.... -->
         <!-- .....:::::: Start Mobile Header Section :::::.... -->
         <div class="mobile-header d-block d-lg-none">
            <div class="container">
               <div class="row align-items-center justify-content-between">
                  <div class="col text-center">
                     <div class="mobile-logo">
                        <a  href=""><img width="200" src="/frontend/images/logo.png" alt=""></a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- .....:::::: Start MobileHeader Section :::::.... -->
       
         <!-- ...::: Start Hero Section :::... -->
        @yield('content')
         <!-- ...::: End Hero Section :::... -->
        
         <!-- ...::: Start Counter Display Section :::... -->
         <div class="counter-display-section section-gap-tb-165 section-bg-2">
            <div class="counter-display-wrapper">
               <div class="container">
                  <div class="row justify-content-center justify-content-sm-start">
                     <div class="d-block d-md-flex justify-content-md-start col-6 col-sm-4 col-md-4">
                        <!-- Start Counterup Single Item -->
                        <div class="counterup-single-item">
                           <div class="icon">
                              <img src="/frontend/images/counterup-icon-1.png" alt="">
                           </div>
                           <div class="content">
                              <h2 class="number"><span class="counter">58</span>K</h2>
                              <span class="text">Sản phẩm đã bán</span>
                           </div>
                        </div>
                        <!-- End Counterup Single Item -->
                     </div>
                     <div class="d-block d-md-flex justify-content-md-center col-6 col-sm-4 col-md-4">
                        <!-- Start Counterup Single Item -->
                        <div class="counterup-single-item">
                           <div class="icon">
                              <img src="/frontend/images/counterup-icon-2.png" alt="">
                           </div>
                           <div class="content">
                              <h2 class="number"><span class="counter">50</span>K</h2>
                              <span class="text">Khách hàng hài lòng</span>
                           </div>
                        </div>
                        <!-- End Counterup Single Item -->
                     </div>
                     <div class="d-block d-md-flex justify-content-md-end col-6 col-sm-4 col-md-4">
                        <!-- Start Counterup Single Item -->
                        <div class="counterup-single-item">
                           <div class="icon">
                              <img src="/frontend/images/counterup-icon-3.png" alt="">
                           </div>
                           <div class="content">
                              <h2 class="number"><span class="counter">13</span>+</h2>
                              <span class="text">Năm kinh nghiệm</span>
                           </div>
                        </div>
                        <!-- End Counterup Single Item -->
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- ...::: End Counter Display Section :::... -->
        
         <!-- ...::: Start Footer Section :::... -->
         <footer class="footer-section section-bg overflow-hidden pos-relative">
            <div class="footer-inner-shape-top-left"></div>
            <div class="footer-inner-shape-top-right"></div>
            <div class="footer-section-top section-gap-t-165">
               <div class="container">
                  <div class="row">
                     <div class="col-12">
                        <!-- Start Section Content -->
                        <div class="section-content pos-relative text-center">
                           <span class="section-tag">Liên hệ</span>
                           <h2 class="section-title">Với chúng tôi</h2>
                        </div>
                        <!-- End Section Content -->
                     </div>
                  </div>
               </div>
            </div>
            <div class="footer-center section-gap-tb-165">
               <div class="container">
                  <div class="row justify-content-between align-items-center mb-n5">
                     <div class="col-auto mb-5">
                        <!-- Start Single Footer Info -->
                        <div class="footer-single-info">
                           <a href="tel:+0123456789" class="info-box">
                           <span class="icon"><i class="icofont-phone"></i></span>
                           <span class="text">0123456789</span>
                           </a>
                        </div>
                        <!-- Start Single Footer Info -->
                     </div>
                     <div class="col-auto mb-5">
                        <!-- Start Single Footer Info -->
                        <div class="footer-single-info">
                           <a href="mailto:pocoloshop@gmail.com" class="info-box">
                           <span class="icon"><i class="icofont-envelope-open"></i></span>
                           <span class="text">pocoloshop@gmail.com</span>
                           </a>
                        </div>
                        <!-- Start Single Footer Info -->
                     </div>
                     <div class="col-auto mb-5">
                        <!-- Start Single Footer Info -->
                        <div class="footer-single-info">
                           <ul class="social-link">
                              <li><a href="https://www.example.com" target="_blank"><i class="icofont-facebook"></i></a></li>
                              <li><a href="https://www.example.com" target="_blank"><i class="icofont-dribbble"></i></a></li>
                              <li><a href="https://www.example.com" target="_blank"><i class="icofont-linkedin"></i></a></li>
                           </ul>
                        </div>
                        <!-- Start Single Footer Info -->
                     </div>
                  </div>
               </div>
            </div>
            <div class="footer-bottom">
               <div class="container">
                  <div class="row justify-content-center justify-content-md-between align-items-center flex-column-reverse flex-md-row">
                     <div class="col-auto">
                        <div class="footer-copyright">
                           <p class="copyright-text">&copy; 2026 <a href="">Pocolo</a> Made with <i class="icofont-heart"></i> by <a href="https://www.facebook.com/luong.xuan.thang.384583" target="_blank">Luong Xuan Thang</a> </p>
                        </div>
                     </div>
                     <div class="col-auto">
                        <a href="" class="footer-logo">
                           <div class="logo">
                              <img width="200" src="/frontend/images/logo.png" alt="">
                           </div>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </footer>
         <!-- ...::: End Footer Section :::... -->
         <!-- material-scrolltop button -->
         <button class="material-scrolltop" type="button"></button>
      </main>

      <script src="/frontend/js/vendor.min.js"></script>
      <script src="/frontend/js/plugins.min.js"></script>
      <!--Main JS (Common Activation Codes)-->
      <script src="/frontend/js/main.js"></script>
      @yield('js')
   </body>
</html>