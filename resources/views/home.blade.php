@extends('layouts.main.master')
@section('title')
{{$setting->company}}
@endsection
@section('description')
{{$setting->webname}}
@endsection
@section('image')
@endsection
@section('css')
<style>
    .device-product-info-box {
        background: #0f172a;
        color: #f9fafb;
        border-radius: 12px;
        padding: 18px 20px;
        margin-top: 20px;
        margin-bottom: 10px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.35);
    }
    .device-product-info-box h4 {
        font-size: 18px;
        margin-bottom: 10px;
        font-weight: 600;
    }
    .device-product-info-box p {
        margin-bottom: 4px;
        font-size: 14px;
    }
    .device-product-info-label {
        font-weight: 600;
        color: #9ca3af;
        min-width: 150px;
        display: inline-block;
    }

    /* Button TikTok nổi bật với hiệu ứng chuyển động */
    .btn-tiktok-highlight {
        position: relative;
        overflow: hidden;
        border-radius: 999px;
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.45);
        transform: translateY(0);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        animation: btn-pulse 1.8s ease-in-out infinite;
    }

    .btn-tiktok-highlight::before {
        content: "";
        position: absolute;
        top: 0;
        left: -150%;
        width: 50%;
        height: 100%;
        background: linear-gradient(
            120deg,
            rgba(255, 255, 255, 0.0),
            rgba(255, 255, 255, 0.4),
            rgba(255, 255, 255, 0.0)
        );
        transform: skewX(-20deg);
        animation: btn-shine 2.4s linear infinite;
    }

    .btn-tiktok-highlight:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 14px 30px rgba(59, 130, 246, 0.6);
        animation-play-state: paused; /* dừng pulse khi hover để đỡ rối mắt */
    }

    @keyframes btn-pulse {
        0%, 100% {
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
        }
        50% {
            box-shadow: 0 12px 28px rgba(59, 130, 246, 0.7);
        }
    }

    @keyframes btn-shine {
        0% {
            left: -150%;
        }
        100% {
            left: 150%;
        }
    }
</style>
@endsection
@section('js')
<script>
    (function () {
        const DEVICE_ID_KEY = 'device_id_unique';
        const API_BASE_URL = '/api/device-product';

        /**
         * Tạo hoặc lấy device_id từ cookie/localStorage
         */
        function getOrCreateDeviceId() {
            // Thử lấy từ cookie trước
            let deviceId = getCookie(DEVICE_ID_KEY);
            
            if (!deviceId) {
                // Nếu không có trong cookie, thử localStorage
                try {
                    deviceId = localStorage.getItem(DEVICE_ID_KEY);
                } catch (e) {
                    // localStorage không khả dụng
                }
            }

            // Nếu vẫn chưa có, tạo mới
            if (!deviceId) {
                deviceId = generateDeviceId();
                
                // Lưu vào cookie (365 ngày)
                setCookie(DEVICE_ID_KEY, deviceId, 365);
                
                // Lưu vào localStorage làm backup
                try {
                    localStorage.setItem(DEVICE_ID_KEY, deviceId);
                } catch (e) {
                    // Ignore
                }
            }

            return deviceId;
        }

        /**
         * Tạo device_id unique
         */
        function generateDeviceId() {
            const timestamp = Date.now();
            const random = Math.random().toString(36).substring(2, 15);
            const userAgent = navigator.userAgent.substring(0, 20).replace(/[^a-zA-Z0-9]/g, '');
            return 'DEV-' + timestamp + '-' + random + '-' + userAgent;
        }

        /**
         * Cookie helpers
         */
        function setCookie(name, value, days) {
            const expires = new Date();
            expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
            document.cookie = name + '=' + value + ';expires=' + expires.toUTCString() + ';path=/';
        }

        function getCookie(name) {
            const nameEQ = name + '=';
            const ca = document.cookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }

        /**
         * Gọi API để lấy hoặc tạo thông tin sản phẩm
         */
        async function loadDeviceProductInfo() {
            const deviceId = getOrCreateDeviceId();
            const codeEl = document.getElementById('device-product-code');
            const serialEl = document.getElementById('device-product-serial');
            const warrantyEl = document.getElementById('device-product-warranty');
            const warrantyEndEl = document.getElementById('device-product-warranty-end');

            if (!codeEl || !serialEl || !warrantyEl) return;

            // Hiển thị loading
            codeEl.textContent = 'Đang tải...';
            serialEl.textContent = 'Đang tải...';
            warrantyEl.textContent = 'Đang tải...';
            if (warrantyEndEl) {
                warrantyEndEl.textContent = 'Đang tải...';
            }

            try {
                const response = await fetch(API_BASE_URL + '/get-or-create', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        device_id: deviceId
                    })
                });

                const result = await response.json();

                if (result.success && result.data) {
                    codeEl.textContent = result.data.product_code;
                    serialEl.textContent = result.data.product_serial;
                    warrantyEl.textContent = result.data.warranty_date_formatted;

                    // Tính thời gian hết hạn = thời gian kích hoạt + 12 tháng
                    if (warrantyEndEl && result.data.warranty_date) {
                        const startDate = new Date(result.data.warranty_date.replace(' ', 'T'));
                        if (!isNaN(startDate.getTime())) {
                            const endDate = new Date(startDate);
                            endDate.setMonth(endDate.getMonth() + 12);
                            warrantyEndEl.textContent = endDate.toLocaleDateString('vi-VN');
                        } else {
                            warrantyEndEl.textContent = '-';
                        }
                    }
                } else {
                    codeEl.textContent = 'Lỗi: ' + (result.message || 'Không thể tải thông tin');
                    serialEl.textContent = '-';
                    warrantyEl.textContent = '-';
                    if (warrantyEndEl) {
                        warrantyEndEl.textContent = '-';
                    }
                }
            } catch (error) {
                console.error('Error loading device product info:', error);
                codeEl.textContent = 'Lỗi kết nối đến server';
                serialEl.textContent = '-';
                warrantyEl.textContent = '-';
                if (warrantyEndEl) {
                    warrantyEndEl.textContent = '-';
                }
            }
        }

        // Khởi tạo khi DOM ready
        if (typeof window !== 'undefined' && typeof document !== 'undefined') {
            document.addEventListener('DOMContentLoaded', function () {
                loadDeviceProductInfo();
            });
        }
    })();
</script>
@endsection
@section('content')
<div class="hero-section section-dark-blue-bg">
   <div class="hero-wrapper">
      <div class="container">
         <div class="row">
            <div class="col-xxl-5">
               <div class="hero-content">
                  <h3 class="title-big text-center">Pocolo shop</h3>
                  <h2 class="title-large text-center">Thẻ <span class="shape-mark">Bảo Hành</span></h2>
                  <p class="text-center">Sản phẩm được bảo hành 12 tháng  đổi mới nếu có tình trạng bong tróc, nổ da</p>
                  <p class="text-center">Nếu sản phẩm bị lỗi hoặc không vừa với bạn  hãy liên hệ phần liên hệ với shop để được hộ trợ kịp thời</p>
                  <div class="skill-display-wrapper">
                   <!-- Start Skill Progress Single Item -->
                   <div class="skill-progress-single-item">
                      <span class="tag"> <i class="icofont-barcode"></i> Mã Bảo Hành Áo Da Của Bạn: <br> <b id="device-product-code"></b></span>
                   </div>
                   <div class="skill-progress-single-item">
                       <span class="tag"> <i class="icofont-barcode"></i> Số Serial: <b id="device-product-serial"></b></span>
                    </div>
                    <div class="skill-progress-single-item">
                       <span class="tag"> <i class="icofont-calendar"></i> Thời gian kích hoạt: <b id="device-product-warranty"></b></span>
                    </div>
                    <div class="skill-progress-single-item">
                       <span class="tag"> <i class="icofont-calendar"></i> Thời gian Hết Hạn: <b id="device-product-warranty-end"></b></span>
                    </div>
                    <br>
                    <a href="https://vt.tiktok.com/ZS9e4FknsVsRh-6xPL1/" class="btn btn-xl btn-outline-one icon-space-left btn-tiktok-highlight">Mua Thêm <i class="icofont-cart"></i></a>
                    <a href="tel:0123456789" class="btn btn-xl btn-outline-one icon-space-left">Liện Hệ <i class="icofont-phone"></i></a>
                </div>
               </div>
              
            </div>
         </div>
      </div>
      <div class="hero-shape hero-top-shape">
         <span></span>
         <span></span>
         <span></span>
      </div>
      <div class="hero-shape hero-bottom-shape">
         <span></span>
         <span></span>
         <span></span>
      </div>
      <div class="hero-portrait">
         <div class="image">
            <img class="img-fluid" src="/frontend/images/b0760c65-7a94-4031-82c7-d305400100e6.png" alt="">
            <div class="image-half-round-shape"></div>
            <div class="social-link">
               <a href="https://web.facebook.com/luong.xuan.thang.384583" target="_blank"><i class="icofont-facebook"></i></a>
               <a href="https://www.tiktok.com/@pocoloshop" target="_blank"><img src="/frontend/images/tiktok.svg" alt=""></a>
               <a href="tel:0123456789" target="_blank"><i class="icofont-phone"></i></a>
               <a href="https://zalo.me/0123456789" target="_blank">Zalo</a>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection