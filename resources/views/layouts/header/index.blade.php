 <!-- Topbar Section Start -->
 <div class="topbar">
   <div class="container">
      <div class="row align-items-center">
         <div class="col-lg-12 col-md-12">
            <!-- Topbar Contact Information Start -->
            <div class="topbar-time">
               <ul>
                  <li><a href="#"><img src="/frontend/images/icon-mail.svg" alt="">{{$setting->email}}</a></li>
                  <li><a href="#"><img src="/frontend/images/icon-location.svg" alt="">{{$setting->address1}}</a></li>
               </ul>
            </div>
            <!-- Topbar Contact Information End -->
         </div>
      </div>
   </div>
</div>
<!-- Topbar Section End -->
<!-- Header Start -->
<header class="main-header">
   <div class="header-sticky">
      <nav class="navbar navbar-expand-lg">
         <div class="container">
            <!-- Logo Start -->
            <a class="navbar-brand" href="{{route('home')}}">
            <img width="160px" src="{{$setting->logo}}" alt="Logo">
            </a>
            <!-- Logo End -->
            <!-- Main Menu Start -->
            <div class="collapse navbar-collapse main-menu">
               <div class="nav-menu-wrapper">
                  <ul class="navbar-nav mr-auto" id="menu">
                     <li class="nav-item ">
                        <a class="nav-link" href="./">Trang chủ</a>
                     </li>
                     <li class="nav-item"><a class="nav-link" href="{{route('aboutUs')}}">Giới thiệu</a></li>
                     <li class="nav-item"><a class="nav-link" href="{{route('allProduct')}}">Sản phẩm</a></li>
                     <li class="nav-item"><a class="nav-link" href="{{route('duanTieuBieu')}}">Dự án</a></li>
                     <li class="nav-item"><a class="nav-link" href="{{route('serviceListAll')}}">Dịch vụ</a></li>
                     <li class="nav-item submenu">
                        <a class="nav-link" href="javascript:void(0)">Blog</a>
                        <ul>        
                           @foreach ($blogCate as $item)
                           <li class="nav-item"><a class="nav-link" href="{{route('listCateBlog',['slug'=>$item->slug])}}">{{languageName($item->name)}}</a></li>
                           @endforeach                                
                       </ul>
                     </li>
                     <li class="nav-item"><a class="nav-link" href="{{route('lienHe')}}">Liên hệ</a></li>
                    
                  </ul>
               </div>
               <!-- Header Social Icons Start -->
               <div class="header-social-icons">
                  <div class="work-facility-item wow fadeInUp" data-wow-delay="0.4s" style="width: 100%;">
                      <div class="icon-box mr-1">
                         <img src="/frontend/images/icon-work-facility-3.svg" alt="">
                      </div>
                      <div class="work-facility-content">
                         <h3 style="font-size: 17px; font-weight: 600;">Hotline hỗ trợ 24/7</h3>
                         <p style="font-size: 15px; font-weight: 600;">{{$setting->phone1}}</p>
                      </div>
                   </div>
               </div>
               <!-- Header Social Icons End -->
            </div>
            <!-- Main Menu End -->
            <div class="navbar-toggle"></div>
         </div>
      </nav>
      <div class="responsive-menu"></div>
   </div>
</header>
<!-- Header End -->
