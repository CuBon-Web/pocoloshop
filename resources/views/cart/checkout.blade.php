<!DOCTYPE html>
<html class="floating-labels multistep">
   <head>
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
      <meta name="description" content=" Thanh toán đơn hàng" />
      <title>Thông tin  - Thanh toán đơn hàng</title>
      <link rel="shortcut icon" href="{{$setting->favicon}}" type="image/x-icon" />
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css" />
      <link rel="stylesheet" href="{{url('frontend/css/checkout.vendor.min.css?v=4fcd86c')}}">
      <link rel="stylesheet" href="{{url('frontend/css/checkout.min.css?v=17ca415')}}">
      <style>
      </style>
      <!-- End checkout custom css -->
      <script src="https://bizweb.dktcdn.net/assets/themes_support/libphonenumber-v3.2.30.min.js?1681267458186"></script>
      <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
   </head>
   <body>
      @php $total = 0; @endphp
      @foreach (session('cart') as $item)
      @php
         if($item['status_variant'] == 1){
            $total += $item['price'] * $item['quantity'] ;
         }else{
            if ($item['discount'] > 0) {
               $total += $item['discount'] * $item['quantity'] ;
            }else{
               $total += $item['price'] * $item['quantity'] ;
            }
         }
         @endphp
      <header class="banner">
         <div class="wrap">
            <div class="logo logo--left">
               <a href="{{route('home')}}">
               <img class="logo__image  logo__image--small " alt="Mew Mobile" src="{{$setting->logo_footer}}" />
               </a>
            </div>
         </div>
      </header>
      <aside>
         <button class="order-summary-toggle" data-toggle="#order-summary" data-toggle-class="order-summary--is-collapsed">
         <span class="wrap">
         <span class="order-summary-toggle__inner">
         <span class="order-summary-toggle__text expandable">
         Đơn hàng ({{count(session('cart'))}} sản phẩm)
         </span>
         <span class="order-summary-toggle__total-recap" data-tg-refresh="refreshDiscount" id="order-summary-total-recap">
            {{number_format($total)}}₫
         </span>
         </span>
         </span>
         </button>
      </aside>
      <div class="content">
         <div class="wrap">
            <main class="main">
               <header class="main__header">
                  <div class="logo logo--left">
                     <a href="/">
                     <img class="logo__image  logo__image--small " alt="Mew Mobile" src="{{$setting->logo_footer}}" />
                     </a>
                  </div>
                  <nav>
                     <ul class="progress-bar">
                        <li class="">
                           <a href="{{route('home')}}">Về trang chủ</a>
                           <span class="progress-bar__pipe"></span>
                        </li>
                        <li class="progress-bar__item progress-bar__item--current">
                           <span>Thông tin</span>
                           <span class="progress-bar__pipe"></span>
                        </li>
                        <li class="progress-bar__item
                           progress-bar__item--muted
                           ">
                           <span>Thanh toán</span>
                        </li>
                     </ul>
                  </nav>
               </header>
               <div class="main__content">
                  <form method="post" novalidate="novalidate" action="{{route('postBill')}}" id="submitForm">
                     @csrf
                     <article class="step animate-floating-labels">
                        <div class="step__sections">
                           <!-- review block -->
                           <!-- end review block -->
                           <!-- main step block-->
                           <section class="section">
                              <div class="section__header">
                                 <div class="layout-flex">
                                    <h2 class="section__title layout-flex__item layout-flex__item--stretch">
                                       <i class="fa fa-id-card-o fa-lg section__title--icon hide-on-desktop"></i>
                                       Thông tin nhận hàng
                                    </h2>
                                 </div>
                              </div>
                              <div class="section__content">
                                 <div class="fieldset">
                                    <div class="field ">
                                       <div class="field__input-wrapper">
                                          <input name="billingEmail"
                                             type="text" class="field__input" placeholder="Email">
                                       </div>
                                    </div>
                                    <div class="field">
                                       <div class="field__input-wrapper">
                                          <input name="billingName" placeholder="Họ và tên" required
                                             type="text" class="field__input form-control">
                                       </div>
                                    </div>
                                    <div class="field ">
                                       <div class="field__input-wrapper" >
                                          <input name="billingPhone" placeholder="Số điện thoại" required
                                             type="text" class="field__input">
                                       </div>
                                    </div>
                                    <div class="field ">
                                       <div class="field__input-wrapper">
                                          <input name="billingAddress" type="text" class="field__input" placeholder="Địa chỉ" required>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </section>
                           <div class="fieldset section section--no-title">
                              <h3 class="visually-hidden">Ghi chú</h3>
                              <div class="field ">
                                 <div class="field__input-wrapper">
                                    <textarea name="note" class="field__input" placeholder="Ghi chú"></textarea>
                                 </div>
                              </div>
                           </div>
                           <!-- end main step block -->
                        </div>
                        <div class="step__footer">
                           <div id="common-alert" data-tg-refresh="refreshError">
                           </div>
                           <div class="step__btn-group">
                              <button class="btn spinner" type="submit">
                                 <span class="spinner-label">
                                Đặt hàng
                                 </span>
                                 <svg xmlns="http://www.w3.org/2000/svg" class="spinner-loader">
                                    <use href="#spinner"></use>
                                 </svg>
                              </button>
                              <a href="{{route('home')}}">Về trang chủ</a>
                           </div>
                        </div>
                     </article>
                  </form>
                  <script>
                     $('#submitForm').validate({
                        rules:{
                           billingName: "required",
                           billingPhone: {
                              required: true,

                           },
                           billingAddress: "required"
                        },
                        messages:{
                           billingName:"Vui lòng nhập tên của bạn",
                           billingAddress: "Vui lòng nhập địa chỉ nhận hàng",
                           billingPhone:{
                              required: "Nhập số điện thoại liên hệ của bạn"
                           }
                        }
                     });
                  </script>
               </div>
            </main>
            <aside class="sidebar">
               <div class="sidebar__header">
                  <h2 class="sidebar__title">
                     Đơn hàng ({{count(session('cart'))}} sản phẩm)
                  </h2>
               </div>
               <div class="sidebar__content">
                  <div id="order-summary" class="order-summary order-summary--is-collapsed">
                     <div class="order-summary__sections">
                        <div class="order-summary__section order-summary__section--product-list order-summary__section--is-scrollable order-summary--collapse-element">
                           <table class="product-table">
                              <caption class="visually-hidden">Chi tiết đơn hàng</caption>
                              <thead class="product-table__header">
                                 <tr>
                                    <th>
                                       <span class="visually-hidden">Ảnh sản phẩm</span>
                                    </th>
                                    <th>
                                       <span class="visually-hidden">Mô tả</span>
                                    </th>
                                    <th>
                                       <span class="visually-hidden">Sổ lượng</span>
                                    </th>
                                    <th>
                                       <span class="visually-hidden">Đơn giá</span>
                                    </th>
                                 </tr>
                              </thead>
                              <tbody>
                                 
                                 <tr class="product">
                                    <td class="product__image">
                                       <div class="product-thumbnail">
                                          <div class="product-thumbnail__wrapper" data-tg-static>
                                             <img src="{{$item['image']}}" alt="" class="product-thumbnail__image" />
                                          </div>
                                          <span class="product-thumbnail__quantity">{{$item['quantity']}}</span>
                                       </div>
                                    </td>
                                    <th class="product__description">
                                       <span class="product__description__name">
                                       {{$item['name']}}
                                       </span>
                                       <span class="product__description__property">
                                          {{$item['variant']}}
                                       </span>
                                    </th>
                                    <td class="product__quantity visually-hidden"><em>Số lượng:</em> {{$item['quantity']}}</td>
                                    @if ($item['status_variant'] == 1)
                                    <td class="product__price">
                                       {{number_format($item['price'])}}₫
                                    </td>
                                    @else 
                                       @if ($item['discount'] > 0)
                                       <td class="product__price">
                                          {{ number_format($item['discount']) }}₫
                                       </td>
                                       @else
                                       <td class="product__price">
                                          {{ number_format($item['price']) }}₫
                                       </td>
                                       @endif
                                    @endif
                                 </tr>
                                 @endforeach
                              </tbody>
                           </table>
                        </div>
                        <div class="order-summary__section order-summary__section--total-lines order-summary--collapse-element"
                           id="orderSummary">
                           <table class="total-line-table">
                              <caption class="visually-hidden">Tổng giá trị</caption>
                              <thead>
                                 <tr>
                                    <td><span class="visually-hidden">Mô tả</span></td>
                                    <td><span class="visually-hidden">Giá tiền</span></td>
                                 </tr>
                              </thead>
                              <tbody class="total-line-table__tbody">
                                 <tr class="total-line total-line--subtotal">
                                    <th class="total-line__name">
                                       Tạm tính
                                    </th>
                                    <td class="total-line__price">{{number_format($total)}}₫</td>
                                 </tr>
                              </tbody>
                              <tfoot class="total-line-table__footer">
                                 <tr class="total-line payment-due">
                                    <th class="total-line__name">
                                       <span class="payment-due__label-total">
                                       Tổng cộng
                                       </span>
                                    </th>
                                    <td class="total-line__price">
                                       <span class="payment-due__price">
                                          {{number_format($total)}}₫
                                       </span>
                                    </td>
                                 </tr>
                              </tfoot>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </aside>
         </div>
      </div>
      <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
         <symbol id="spinner">
            <svg viewBox="0 0 30 30">
               <circle stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-dasharray="85%"
                  cx="50%" cy="50%" r="40%">
                  <animateTransform attributeName="transform"
                     type="rotate"
                     from="0 15 15"
                     to="360 15 15"
                     dur="0.7s"
                     repeatCount="indefinite" />
               </circle>
            </svg>
         </symbol>
         <symbol id="angle-right">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
               <path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path>
            </svg>
         </symbol>
      </svg>
   </body>
</html>