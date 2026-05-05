<!DOCTYPE html>
<html class="thankyou-page">
   <head>
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
      <meta name="description" content="Đặt hàng thành công" />
      <title>Đặt hàng thành công</title>
      <link rel="shortcut icon" href="{{$setting->favicon}}" type="image/x-icon" />
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css" />
      <link rel="stylesheet" href="{{url('frontend/css/checkout.vendor.min.css?v=4fcd86c')}}">
      <link rel="stylesheet" href="{{url('frontend/css/checkout.min.css?v=17ca415')}}">
   </head>
   <body data-no-turbolink>
      <header class="banner">
         <div class="wrap">
            <div class="logo logo--left">
               <a href="{{route('home')}}">
               <img class="logo__image  logo__image--small " alt="Mew Mobile" src="{{$setting->logo}}" />
               </a>
            </div>
         </div>
      </header>
      <div class="content">
         <form>
            <div class="wrap wrap--mobile-fluid">
               <main class="main main--nosidebar">
                  <header class="main__header">
                     <div class="logo logo--left">
                        <a href="/">
                        <img class="logo__image  logo__image--small " alt="Mew Mobile" src="{{$setting->logo}}" />
                        </a>
                     </div>
                  </header>
                  <div class="main__content">
                     <article class="row">
                        <div class="col">
                           <section class="section section--icon-heading">
                              <div class="section__icon unprintable">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="72px" height="72px">
                                    <g fill="none" stroke="#8EC343" stroke-width="2">
                                       <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>
                                       <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
                                    </g>
                                 </svg>
                              </div>
                              <div class="thankyou-message-container">
                                 <h2 class="section__title">Cảm ơn bạn đã đặt hàng</h2>
                              </div>
                           </section>
                        </div>
                        <div class="col col--primary">
                           <section class="section unprintable">
                              <div class="field__input-btn-wrapper field__input-btn-wrapper--floating">
                                 <a href="/" class="btn btn--large">Tiếp tục mua hàng</a>
                                 <span class="text-icon-group text-icon-group--large icon-print" onclick="window.print()">
                                 <i class="fa fa-print"></i>
                                 <span>In </span>
                                 </span>
                              </div>
                           </section>
                        </div>
                     </article>
                  </div>
               </main>
            </div>
         </form>
      </div>
   </body>
</html>