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
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
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

    @keyframes  btn-pulse {
        0%, 100% {
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
        }
        50% {
            box-shadow: 0 12px 28px rgba(59, 130, 246, 0.7);
        }
    }

    @keyframes  btn-shine {
        0% {
            left: -150%;
        }
        100% {
            left: 150%;
        }
    }

    .device-location-section {
        padding: 0;
        background: #282a37;
    }

    .device-location-card {
        background: #282a37;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
    }

    .device-location-card h3 {
        font-size: 26px;
        margin-bottom: 8px;
        font-weight: 700;
        color: #f9fafb;
    }

    .device-location-card .location-note {
        font-size: 14px;
        color: #ffffff;
        margin-bottom: 16px;
    }

    .device-location-status {
        min-height: 24px;
        margin-bottom: 12px;
        font-size: 14px;
        color: #ffffff;
    }

    .device-location-status.is-error {
        color: #dc2626;
    }

    .device-location-status.is-success {
        color: #ffffff;
    }

    #device-location-map {
        width: 100%;
        height: 360px;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        background: #e2e8f0;
    }

    .device-location-search {
        margin-top: 16px;
        padding: 0;
    }

    .device-location-search-form {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 4px 18px;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 12px;
        transition: border-color 0.2s ease, background 0.2s ease;
    }

    .device-location-search-form:focus-within {
        background: rgba(255, 255, 255, 0.1);
        border-color: #3b82f6;
    }

    .device-location-search-form button {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        background: transparent;
        border: none;
        color: #9ca3af;
        font-size: 18px;
        cursor: pointer;
    }

    .device-location-search-form button:hover {
        color: #f9fafb;
    }

    .device-location-search-form input {
        flex: 1;
        min-width: 0;
        padding: 12px 0;
        background: transparent;
        border: none;
        color: #f9fafb;
        text-transform: uppercase;
    }

    .device-location-search-form input::placeholder {
        color: #9ca3af;
        text-transform: none;
    }

    .device-location-search-form input:focus {
        outline: none;
    }

</style>
@endsection
@section('js')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    (function () {
        const DEVICE_ID_KEY = 'device_id_unique';
        const API_BASE_URL = '/api/device-product';

        let currentDeviceId = null;
        let deviceMap = null;
        let deviceMarker = null;
        let accuracyCircle = null;

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

        function setLocationStatus(message, type) {
            const statusEl = document.getElementById('device-location-status');
            if (!statusEl) return;
            statusEl.textContent = message || '';
            statusEl.classList.remove('is-error', 'is-success');
            if (type === 'error') statusEl.classList.add('is-error');
            if (type === 'success') statusEl.classList.add('is-success');
        }

        function initMapPlaceholder() {
            const mapEl = document.getElementById('device-location-map');
            if (!mapEl || typeof L === 'undefined') return;

            if (!deviceMap) {
                deviceMap = L.map(mapEl, {
                    zoomControl: true,
                    attributionControl: true
                }).setView([16.047079, 108.206230], 5);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(deviceMap);
            }

            setTimeout(function () {
                if (deviceMap) deviceMap.invalidateSize();
            }, 100);
        }

        function showLocationOnMap(latitude, longitude, accuracy) {
            if (typeof L === 'undefined') {
                setLocationStatus('Không thể tải thư viện bản đồ.', 'error');
                return;
            }

            initMapPlaceholder();
            if (!deviceMap) return;

            const lat = Number(latitude);
            const lng = Number(longitude);
            if (isNaN(lat) || isNaN(lng)) return;

            if (deviceMarker) {
                deviceMarker.setLatLng([lat, lng]);
            } else {
                deviceMarker = L.marker([lat, lng]).addTo(deviceMap);
            }

            deviceMarker.bindPopup('Vị trí sản phẩm của bạn').openPopup();

            if (accuracyCircle) {
                deviceMap.removeLayer(accuracyCircle);
                accuracyCircle = null;
            }

            const radius = Number(accuracy);
            if (!isNaN(radius) && radius > 0) {
                accuracyCircle = L.circle([lat, lng], {
                    radius: radius,
                    color: '#2563eb',
                    fillColor: '#3b82f6',
                    fillOpacity: 0.15,
                    weight: 1
                }).addTo(deviceMap);
                deviceMap.fitBounds(accuracyCircle.getBounds(), { padding: [30, 30], maxZoom: 16 });
            } else {
                deviceMap.setView([lat, lng], 15);
            }

            setTimeout(function () {
                if (deviceMap) deviceMap.invalidateSize();
            }, 100);
        }

        function handleExistingLocation(data) {
            if (data && data.has_location && data.latitude != null && data.longitude != null) {
                setLocationStatus('Đã hiển thị vị trí đã lưu của sản phẩm.', 'success');
                showLocationOnMap(data.latitude, data.longitude, data.location_accuracy);
                return true;
            }
            return false;
        }

        async function saveDeviceLocation(latitude, longitude, accuracy) {
            const response = await fetch(API_BASE_URL + '/location', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    device_id: currentDeviceId,
                    latitude: latitude,
                    longitude: longitude,
                    accuracy: accuracy
                })
            });

            const result = await response.json();
            if (!response.ok || !result.success) {
                throw new Error((result && result.message) || 'Không thể lưu vị trí');
            }
            return result.data;
        }

        async function searchLocationBySerial() {
            const inputEl = document.getElementById('location-serial-input');
            const buttonEl = document.getElementById('location-serial-search');
            const productSerial = inputEl ? inputEl.value.trim().toUpperCase() : '';

            if (!productSerial) {
                setLocationStatus('Vui lòng nhập số serial cần tìm.', 'error');
                if (inputEl) inputEl.focus();
                return;
            }

            if (buttonEl) buttonEl.disabled = true;
            setLocationStatus('Đang tìm vị trí theo số serial...', null);

            try {
                const response = await fetch(API_BASE_URL + '/location-by-serial', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_serial: productSerial
                    })
                });

                const result = await response.json();
                if (!response.ok || !result.success) {
                    throw new Error((result && result.message) || 'Không thể tìm vị trí sản phẩm');
                }

                if (!result.data.has_location) {
                    setLocationStatus('Sản phẩm ' + result.data.product_serial + ' chưa lưu vị trí.', 'error');
                    return;
                }

                showLocationOnMap(
                    result.data.latitude,
                    result.data.longitude,
                    result.data.location_accuracy
                );
                setLocationStatus(
                    'Đã tìm thấy vị trí của sản phẩm ' + result.data.product_serial + '.',
                    'success'
                );
            } catch (error) {
                console.error('Error searching product location:', error);
                setLocationStatus(error.message || 'Không thể tìm vị trí sản phẩm.', 'error');
            } finally {
                if (buttonEl) buttonEl.disabled = false;
            }
        }

        function requestAndSaveLocation() {
            if (!currentDeviceId) {
                setLocationStatus('Chưa có mã sản phẩm. Vui lòng tải lại trang.', 'error');
                return;
            }

            if (!navigator.geolocation) {
                setLocationStatus('Trình duyệt không hỗ trợ định vị.', 'error');
                return;
            }

            const isSecure = window.isSecureContext || location.protocol === 'https:' || location.hostname === 'localhost' || location.hostname === '127.0.0.1';
            if (!isSecure) {
                setLocationStatus('Định vị chỉ hoạt động trên HTTPS hoặc localhost.', 'error');
                return;
            }

            setLocationStatus('Đang lấy vị trí thiết bị...', null);

            navigator.geolocation.getCurrentPosition(async function (position) {
                try {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    const accuracy = position.coords.accuracy;

                    const data = await saveDeviceLocation(latitude, longitude, accuracy);
                    setLocationStatus('Đã lưu và hiển thị vị trí thiết bị.', 'success');
                    showLocationOnMap(
                        data.latitude != null ? data.latitude : latitude,
                        data.longitude != null ? data.longitude : longitude,
                        data.location_accuracy != null ? data.location_accuracy : accuracy
                    );
                } catch (error) {
                    console.error('Error saving device location:', error);
                    setLocationStatus(error.message || 'Lỗi khi lưu vị trí.', 'error');
                }
            }, function (error) {
                let message = 'Không thể lấy vị trí thiết bị.';
                if (error.code === error.PERMISSION_DENIED) {
                    message = 'Bạn đã từ chối quyền định vị. Hãy bật lại quyền trong trình duyệt nếu muốn lưu vị trí.';
                } else if (error.code === error.POSITION_UNAVAILABLE) {
                    message = 'Không lấy được tín hiệu vị trí. Vui lòng thử lại.';
                } else if (error.code === error.TIMEOUT) {
                    message = 'Hết thời gian chờ lấy vị trí. Vui lòng thử lại.';
                }
                setLocationStatus(message, 'error');
            }, {
                enableHighAccuracy: true,
                timeout: 15000,
                maximumAge: 0
            });
        }

        /**
         * Gọi API để lấy hoặc tạo thông tin sản phẩm
         */
        async function loadDeviceProductInfo() {
            const deviceId = getOrCreateDeviceId();
            currentDeviceId = deviceId;
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

                    // Vị trí: nếu chưa có thì tự động yêu cầu quyền định vị
                    if (!handleExistingLocation(result.data)) {
                        initMapPlaceholder();
                        requestAndSaveLocation();
                    }
                } else {
                    codeEl.textContent = 'Lỗi: ' + (result.message || 'Không thể tải thông tin');
                    serialEl.textContent = '-';
                    warrantyEl.textContent = '-';
                    if (warrantyEndEl) {
                        warrantyEndEl.textContent = '-';
                    }
                    setLocationStatus('Không thể tải thông tin bảo hành để gắn vị trí.', 'error');
                    initMapPlaceholder();
                }
            } catch (error) {
                console.error('Error loading device product info:', error);
                codeEl.textContent = 'Lỗi kết nối đến server';
                serialEl.textContent = '-';
                warrantyEl.textContent = '-';
                if (warrantyEndEl) {
                    warrantyEndEl.textContent = '-';
                }
                setLocationStatus('Lỗi kết nối đến server khi tải thông tin thiết bị.', 'error');
                initMapPlaceholder();
            }
        }

        // Khởi tạo khi DOM ready
        if (typeof window !== 'undefined' && typeof document !== 'undefined') {
            document.addEventListener('DOMContentLoaded', function () {
                const serialInput = document.getElementById('location-serial-input');
                const serialSearchButton = document.getElementById('location-serial-search');

                if (serialSearchButton) {
                    serialSearchButton.addEventListener('click', searchLocationBySerial);
                }
                if (serialInput) {
                    serialInput.addEventListener('keydown', function (event) {
                        if (event.key === 'Enter') {
                            event.preventDefault();
                            searchLocationBySerial();
                        }
                    });
                }

                initMapPlaceholder();
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
                    <a href="https://vt.tiktok.com/ZS9rRhDCsEHVA-Svy8R" class="btn btn-xl btn-outline-one icon-space-left btn-tiktok-highlight">Mua Thêm <i class="icofont-cart"></i></a>
                    <a href="https://www.tiktok.com/@pocoloshop" class="btn btn-xl btn-outline-one icon-space-left">Liện Hệ <i class="icofont-phone"></i></a>
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

<section class="device-location-section">
   <div class="container">
      <div class="device-location-card">
         <h3>Vị trí sản phẩm của bạn trên bản đồ</h3>
         <div id="device-location-status" class="device-location-status"></div>
         <div id="device-location-map" aria-label="Bản đồ vị trí thiết bị"></div>
      </div>
      <div class="device-location-search">
         <div class="device-location-search-form">
            <button type="button" id="location-serial-search" aria-label="Tìm vị trí sản phẩm">
               <i class="icofont-search-1"></i>
            </button>
            <input
               type="text"
               id="location-serial-input"
               maxlength="50"
               placeholder="Nhập mã serial tìm kiếm sản phẩm"
               aria-label="Nhập mã serial tìm kiếm sản phẩm"
               autocomplete="off"
            >
         </div>
      </div>
   </div>
</section>
@endsection
