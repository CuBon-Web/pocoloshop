@extends('layouts.main.master')
@section('title')
{{$product->name}}
@endsection
@section('description')
{{languageName($product->description)}}
@endsection
@section('image')
@php
$img = json_decode($product->images, true);
$ungdung = json_decode($product->preserve, true);
$thongsos = json_decode($product->size, true);
if(!is_array($img)) $img = [];
if(!is_array($ungdung)) $ungdung = [];
if(!is_array($thongsos)) $thongsos = [];
@endphp
{{url(''.($img[0] ?? ''))}}
@endsection
@section('css')
<style>
.product-detail-section {
	padding: 80px 0;
}
.product-gallery-main {
	margin-bottom: 20px;
	border-radius: 10px;
	overflow: hidden;
	position: relative;
	/* box-shadow: 0 5px 20px rgba(0,0,0,0.1); */
}
.product-gallery-main img {
	width: 100%;
	height: 500px;
	object-fit: cover;
	display: block;
}
.product-gallery-main .swiper-button-next,
.product-gallery-main .swiper-button-prev {
	color: var(--primary-color);
	background: rgba(255, 255, 255, 0.9);
	width: 40px;
	height: 40px;
	border-radius: 50%;
}
.product-gallery-main .swiper-button-next:after,
.product-gallery-main .swiper-button-prev:after {
	font-size: 18px;
	font-weight: bold;
}
.product-gallery-main .swiper-button-next:hover,
.product-gallery-main .swiper-button-prev:hover {
	background: var(--primary-color);
	color: #fff;
}
.product-gallery-thumbs {
	margin-top: 15px;
}
.product-gallery-thumbs .swiper-slide {
	cursor: pointer;
	border-radius: 8px;
	overflow: hidden;
	border: 3px solid transparent;
	transition: all 0.3s ease;
	opacity: 0.6;
}
.product-gallery-thumbs .swiper-slide:hover {
	opacity: 1;
	border-color: var(--primary-color);
}
.product-gallery-thumbs .swiper-slide-thumb-active {
	border-color: var(--primary-color);
	opacity: 1;
}
.product-gallery-thumbs img {
	width: 100%;
	height: 100px;
	object-fit: cover;
	display: block;
}
.product-info-box {
	background: #fff;
	padding: 30px;
	border-radius: 10px;
	/* box-shadow: 0 5px 20px rgba(0,0,0,0.08); */
}
.product-title {
	font-size: 32px;
	font-weight: 700;
	color: var(--primary-color);
	margin-bottom: 20px;
	line-height: 1.3;
}
.product-price-box {
	margin: 25px 0;
	padding: 20px;
	background: #f8f9fa;
	border-radius: 8px;
	border-left: 4px solid var(--primary-color);
}
.product-price {
	font-size: 28px;
	font-weight: 700;
	color: var(--primary-color);
}
.product-price-old {
	font-size: 20px;
	color: #999;
	text-decoration: line-through;
	margin-left: 15px;
}
.product-contact-box {
	margin-top: 30px;
	padding: 20px;
	background: #fff;
	border-radius: 10px;
	box-shadow: 0 3px 15px rgba(0,0,0,0.1);
	border: 1px solid #e9ecef;
}
.product-contact-box h4 {
	color: var(--primary-color);
	margin-bottom: 15px;
	font-size: 18px;
	font-weight: 600;
	text-align: center;
}
.contact-buttons {
	display: flex;
	gap: 10px;
	flex-wrap: wrap;
	justify-content: center;
}
.contact-btn {
	flex: 1;
    gap: 7px;
    min-width: 100px;
    display: flex;
    /* flex-direction: column; */
    align-items: center;
    justify-content: center;
    padding: 15px 10px;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
    /* border: 2px solid transparent; */
    font-size: 17px;
    font-weight: 600;
}
.contact-btn i {
	font-size: 24px;
	/* margin-bottom: 8px; */
}
.contact-btn-hotline {
	background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
	color: #fff;
}
.contact-btn-hotline:hover {
	transform: translateY(-3px);
	box-shadow: 0 5px 15px rgba(37, 211, 102, 0.4);
	color: #fff;
}
.contact-btn-messenger {
	background: linear-gradient(135deg, #0084FF 0%, #0066CC 100%);
	color: #fff;
}
.contact-btn-messenger:hover {
	transform: translateY(-3px);
	box-shadow: 0 5px 15px rgba(0, 132, 255, 0.4);
	color: #fff;
}
.contact-btn-facebook {
	background: linear-gradient(135deg, #1877F2 0%, #0C5A9E 100%);
	color: #fff;
}
.contact-btn-facebook:hover {
	transform: translateY(-3px);
	box-shadow: 0 5px 15px rgba(24, 119, 242, 0.4);
	color: #fff;
}
.contact-btn span {
	font-size: 15px;
    margin-top: 5px;
    text-align: center;
    line-height: 1.2;
}
.specs-table {
	width: 100%;
	border-collapse: collapse;
	margin-top: 20px;
}
.specs-table tr {
	border-bottom: 1px solid #e9ecef;
}
.specs-table td {
	padding: 15px;
}
.specs-table td:first-child {
	font-weight: 600;
	color: var(--primary-color);
	width: 40%;
	background: #f8f9fa;
}
.product-description {
	margin-top: 50px;
	padding: 0px;
	background: #fff;
	border-radius: 10px;
	/* box-shadow: 0 5px 20px rgba(0,0,0,0.08); */
}
.product-description h3 {
	color: var(--primary-color);
	margin-bottom: 25px;
	font-size: 26px;
}
.related-products {
	margin-top: 80px;
	padding: 60px 0;
	background: #f8f9fa;
}
.related-product-item {
	background: #fff;
	border-radius: 10px;
	overflow: hidden;
	box-shadow: 0 3px 15px rgba(0,0,0,0.1);
	transition: all 0.3s ease;
	margin-bottom: 30px;
}
.related-product-item:hover {
	transform: translateY(-5px);
	box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}
.related-product-item img {
	width: 100%;
	height: 250px;
	object-fit: cover;
}
.related-product-item .product-info {
	padding: 20px;
}
.related-product-item h4 {
	font-size: 18px;
	margin-bottom: 10px;
}
.related-product-item h4 a {
	color: var(--text-color);
	text-decoration: none;
	transition: color 0.3s ease;
}
.related-product-item h4 a:hover {
	color: var(--primary-color);
}
@media (max-width: 768px) {
	.product-title {
		font-size: 24px;
	}
	.product-gallery-main img {
		height: 300px;
	}
	.product-info-box {
		padding: 20px;
	}
	.contact-buttons {
		flex-direction: column;
	}
	.contact-btn {
		width: 100%;
		flex-direction: row;
		justify-content: flex-start;
		padding: 12px 15px;
	}
	.contact-btn i {
		margin-right: 10px;
		margin-bottom: 0;
		font-size: 20px;

	}
	.contact-btn span {
		margin-top: 0;
		font-size: 14px;
	}
}
</style>
@endsection
@section('js')
<script>
(function() {
	// Wait for Swiper to be loaded
	function initProductGallery() {
		if (typeof Swiper === 'undefined') {
			setTimeout(initProductGallery, 100);
			return;
		}

		const galleryThumbsEl = document.querySelector('.product-gallery-thumbs');
		const galleryMainEl = document.querySelector('.product-gallery-main');
		
		if (!galleryThumbsEl || !galleryMainEl) {
			return;
		}

		// Initialize Thumbs Swiper
		const galleryThumbs = new Swiper('.product-gallery-thumbs', {
			spaceBetween: 10,
			slidesPerView: 4,
			freeMode: true,
			watchSlidesProgress: true,
			breakpoints: {
				576: {
					slidesPerView: 4,
				},
				768: {
					slidesPerView: 5,
				},
				992: {
					slidesPerView: 4,
				}
			}
		});

		// Initialize Main Swiper
		const galleryMain = new Swiper('.product-gallery-main', {
			spaceBetween: 10,
			loop: false,
			thumbs: {
				swiper: galleryThumbs
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			}
		});

		// Click thumb to change main image
		const thumbSlides = document.querySelectorAll('.product-gallery-thumbs .swiper-slide');
		thumbSlides.forEach(function(thumb, index) {
			thumb.addEventListener('click', function() {
				galleryMain.slideTo(index);
			});
		});
	}

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initProductGallery);
	} else {
		initProductGallery();
	}
})();
</script>
@endsection
@section('content')
<div class="page-header parallaxie">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-12">
				<!-- Page Header Box Start -->
				<div class="page-header-box">
					<h1 data-cursor="-opaque">{{($product->name)}}</h1>
					<nav class="wow fadeInUp">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{route('home')}}">Trang chủ</a></li>
							<li class="breadcrumb-item active" aria-current="page">Sản Phẩm</li>
							<li class="breadcrumb-item active" aria-current="page">{{($product->name)}}</li>
						</ol>
					</nav>
				</div>
				<!-- Page Header Box End -->
			</div>
		</div>
	</div>
</div>

<!-- Product Detail Section Start -->
<section class="product-detail-section">
	<div class="container">
		<div class="row">
			<!-- Product Gallery Start -->
			<div class="col-lg-6">
				<div class="product-gallery">
					<!-- Main Image Swiper -->
					@if(count($img) > 0)
					<div class="swiper product-gallery-main">
						<div class="swiper-wrapper">
							@foreach($img as $image)
							@if(is_string($image))
							<div class="swiper-slide">
								<img src="{{url(''.$image)}}" alt="{{$product->name}}" loading="lazy">
							</div>
							@endif
							@endforeach
						</div>
						<!-- Navigation buttons -->
						<div class="swiper-button-next"></div>
						<div class="swiper-button-prev"></div>
					</div>
					<!-- Thumbnails Swiper -->
					@if(count($img) > 1)
					<div class="swiper product-gallery-thumbs">
						<div class="swiper-wrapper">
							@foreach($img as $image)
							@if(is_string($image))
							<div class="swiper-slide">
								<img src="{{url(''.$image)}}" alt="{{$product->name}}" loading="lazy">
							</div>
							@endif
							@endforeach
						</div>
					</div>
					@endif
					@else
					<div class="product-gallery-main">
						<img src="{{url('/frontend/images/no-image.jpg')}}" alt="{{$product->name}}" style="width: 100%; height: 500px; object-fit: cover;">
					</div>
					@endif
				</div>
			</div>
			<!-- Product Gallery End -->

			<!-- Product Info Start -->
			<div class="col-lg-6">
				<div class="product-info-box wow fadeInUp">
					<h1 class="product-title">{{($product->name)}}</h1>
					
					<!-- Product Description Short -->
					@if($product->description)
					<div class="product-short-desc">
						{!!languageName($product->description)!!}
					</div>
					@endif

					

					<!-- Contact Methods -->
					<div class="product-contact-box">
						<h4>Liên hệ tư vấn</h4>
						<div class="contact-buttons">
							<!-- Hotline -->
							<a href="tel:{{$setting->phone1}}" class="contact-btn contact-btn-hotline" title="Gọi điện thoại">
								<i class="fab fa-whatsapp"></i>
								<span>Hotline</span>
							</a>
							
							<!-- Messenger -->
							@php
								$messengerUrl = $setting->messenger_url ?? $setting->facebook_url ?? 'https://m.me/' . str_replace(['https://', 'http://', 'www.', 'facebook.com/', 'fb.com/'], '', $setting->facebook_url ?? '');
							@endphp
							<a href="{{$messengerUrl}}" target="_blank" class="contact-btn contact-btn-messenger" title="Nhắn tin Messenger">
								<i class="fab fa-facebook-messenger"></i>
								<span>Messenger</span>
							</a>
							
							<!-- Facebook -->
							@if($setting->facebook ?? null)
							<a href="{{$setting->facebook}}" target="_blank" class="contact-btn contact-btn-facebook" title="Facebook">
								<i class="fab fa-facebook-f"></i>
								<span>Facebook</span>
							</a>
							@else
							<a href="https://facebook.com" target="_blank" class="contact-btn contact-btn-facebook" title="Facebook">
								<i class="fab fa-facebook-f"></i>
								<span>Facebook</span>
							</a>
							@endif
						</div>
					</div>
				</div>
			</div>
			<!-- Product Info End -->
		</div>
	</div>
</section>
<!-- Product Detail Section End -->

<!-- Product Specifications Start -->
@if($thongsos && is_array($thongsos) && count($thongsos) > 0)
<section class="product-specs-section" style="padding: 60px 0; background: #f8f9fa;">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="section-title text-center wow fadeInUp">
					<h3>Thông số kỹ thuật</h3>
					<h2 class="text-anime-style-3" data-cursor="-opaque">Đặc điểm nổi bật</h2>
				</div>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-lg-10">
				<div class="product-info-box wow fadeInUp" data-wow-delay="0.2s">
					<table class="specs-table">
						@foreach($thongsos as $key => $value)
						<tr>
							<td>{{$value['title']}}</td>
							<td>{{$value['detail']}}</td>
						</tr>
						@endforeach
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
@endif
<!-- Product Specifications End -->

<!-- Product Applications Start -->
@if($ungdung && is_array($ungdung) && count($ungdung) > 0)
<section class="product-applications-section" style="padding: 60px 0;">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="section-title text-center wow fadeInUp">
					<h3>Ứng dụng</h3>
					<h2 class="text-anime-style-3" data-cursor="-opaque">Phạm vi sử dụng</h2>
				</div>
			</div>
		</div>
		<div class="row">
			@foreach($ungdung as $app)
			<div class="col-lg-4 col-md-6">
				<div class="service-box-item wow fadeInUp" data-wow-delay="0.{{$loop->index}}s">
					<div class="icon-box">
						<i class="fa fa-check-circle" style="font-size: 40px; color: var(--primary-color);"></i>
					</div>
					<div class="service-item-content">
						<h3>{{is_string($app) ? $app : (is_object($app) ? json_encode($app) : '')}}</h3>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</section>
@endif
<!-- Product Applications End -->

<!-- Product Description Start -->
@if($product->content)
<section class="product-description-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="product-description wow fadeInUp">
					<h3>Mô tả chi tiết</h3>
					
						{!!languageName($product->content)!!}
					{{-- </div> --}}
				</div>
			</div>
		</div>
	</div>
</section>
@endif
<!-- Product Description End -->

<!-- Related Products Start -->
@if(isset($productlq) && count($productlq) > 0)
<section class="related-products">
	<div class="container">
		<div class="row section-row align-items-center">
			<div class="col-lg-6">
				<div class="section-title">
					<h3 class="wow fadeInUp">Sản phẩm liên quan</h3>
					<h2 class="text-anime-style-3" data-cursor="-opaque">Có thể bạn quan tâm</h2>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="section-title-content">
					<p class="wow fadeInUp" data-wow-delay="0.2s">Khám phá thêm các sản phẩm cùng danh mục với đa dạng mẫu mã và tính năng.</p>
				</div>
			</div>
		</div>
		<div class="row">
			@foreach($productlq as $item)
			@php
				$itemImg = json_decode($item->images, true);
				if(!is_array($itemImg)) $itemImg = [];
			@endphp
			<div class="col-lg-3 col-md-4 col-sm-6">
				<div class="related-product-item wow fadeInUp" data-wow-delay="0.{{$loop->index}}s">
					<a href="{{route('detailProduct',['cate'=>$item->cate_slug,'type'=>$item->type_slug ? $item->type_slug : 'loai','id'=>$item->slug])}}">
						<img src="{{url(''.($itemImg[0] ?? ''))}}" alt="{{$item->name}}">
					</a>
					<div class="product-info">
						<h4>
							<a href="{{route('detailProduct',['cate'=>$item->cate_slug,'type'=>$item->type_slug ? $item->type_slug : 'loai','id'=>$item->slug])}}">
								{{$item->name}}
							</a>
						</h4>
						@if($item->price > 0)
						@if($item->discount > 0 && $item->discount < $item->price)
						<div style="color: var(--primary-color); font-weight: 600;">
							{{number_format($item->discount)}}₫
							<del style="color: #999; font-size: 14px;">{{number_format($item->price)}}₫</del>
						</div>
						@else
						<div style="color: var(--primary-color); font-weight: 600;">
							{{number_format($item->price)}}₫
						</div>
						@endif
						@else
						<div style="color: var(--primary-color); font-weight: 600;">Liên hệ</div>
						@endif
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</section>
@endif
<!-- Related Products End -->

@endsection


