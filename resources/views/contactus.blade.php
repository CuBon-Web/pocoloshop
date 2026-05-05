@extends('layouts.main.master')
@section('title')
Liên hệ với chúng tôi
@endsection
@section('description')
Liên hệ với chúng tôi
@endsection
@section('image')
{{url(''.$setting->logo)}}
@endsection
@section('css')
<style>
.page-contact-us {
	padding: 80px 0;
}
.contact-info-item {
	background: #fff;
	border-radius: 12px;
	padding: 30px 25px;
	box-shadow: 0 3px 15px rgba(0,0,0,0.08);
	transition: all 0.3s ease;
	border: 1px solid #e9ecef;
	height: 100%;
	display: flex;
	flex-direction: column;
	align-items: center;
	text-align: center;
	position: relative;
	overflow: hidden;
}
.contact-info-item::before {
	content: '';
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 4px;
	background: linear-gradient(90deg, var(--primary-color) 0%, var(--accent-color) 100%);
	transform: scaleX(0);
	transition: transform 0.3s ease;
}
.contact-info-item:hover {
	transform: translateY(-5px);
	box-shadow: 0 8px 25px rgba(0,0,0,0.15);
	border-color: var(--primary-color);
}
.contact-info-item:hover::before {
	transform: scaleX(1);
}
.contact-info-item .icon-box {
	width: 80px;
	height: 80px;
	background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
	border-radius: 50%;
	display: flex;
	align-items: center;
	justify-content: center;
	margin-bottom: 20px;
	transition: all 0.3s ease;
	position: relative;
	z-index: 1;
}
.contact-info-item:hover .icon-box {
	transform: scale(1.1) rotate(5deg);
	box-shadow: 0 5px 20px rgba(225, 45, 49, 0.3);
}
.contact-info-item .icon-box img {
	width: 40px;
	height: 40px;
	object-fit: contain;
	filter: brightness(0) invert(1);
	transition: all 0.3s ease;
}
.contact-info-item:hover .icon-box img {
	transform: scale(1.1);
}
.contact-info-content {
	flex: 1;
	width: 100%;
}
.contact-info-content h3 {
	font-size: 18px;
	font-weight: 600;
	color: var(--primary-color);
	margin-bottom: 12px;
	text-transform: capitalize;
	letter-spacing: 0.5px;
}
.contact-info-content p {
	margin: 0;
	font-size: 15px;
	color: var(--text-color);
	line-height: 1.6;
	word-break: break-word;
}
.contact-info-content p a {
	color: var(--text-color);
	text-decoration: none;
	transition: color 0.3s ease;
}
.contact-info-content p a:hover {
	color: var(--primary-color);
}
@media (max-width: 768px) {
	.contact-info-item {
		padding: 25px 20px;
		margin-bottom: 20px;
	}
	.contact-info-item .icon-box {
		width: 70px;
		height: 70px;
		margin-bottom: 15px;
	}
	.contact-info-item .icon-box img {
		width: 35px;
		height: 35px;
	}
	.contact-info-content h3 {
		font-size: 16px;
		margin-bottom: 10px;
	}
	.contact-info-content p {
		font-size: 14px;
	}
}
</style>
@endsection
@section('js')
@endsection
@section('content')
<div class="page-header parallaxie">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-12">
				<!-- Page Header Box Start -->
				<div class="page-header-box">
					<h1 data-cursor="-opaque">Liên hệ với chúng tôi</h1>
					<nav class="wow fadeInUp">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{route('home')}}">Trang chủ</a></li>
							<li class="breadcrumb-item active" aria-current="page">Liên hệ với chúng tôi</li>
						</ol>
					</nav>
				</div>
				<!-- Page Header Box End -->
			</div>
		</div>
	</div>
</div>
<div class="page-contact-us">
	<div class="container">
		<div class="row section-row">
			<div class="col-lg-12">
				<!-- Section Title Start -->
				<div class="section-title">
					<h3 class="wow fadeInUp">Thông tin liên hệ</h3>
					<h2 class="text-anime-style-3" data-cursor="-opaque">Chúng tôi sẽ hỗ trợ bạn tốt nhất</h2>
				</div>
				<!-- Section Title End -->
			</div>
		</div>

		<div class="row">
			<div class="col-lg-4 col-md-6">
				<!-- Conatct Info Item Start -->
				<div class="contact-info-item wow fadeInUp">
					<div class="icon-box">
						<img src="/frontend/images/icon-location.svg" alt="">
					</div>
					<div class="contact-info-content">
						<h3>Địa chỉ:</h3>
						<p>{{$setting->address1}}</p>
					</div>
				</div>
				<!-- Conatct Info Item End -->
			</div>

			<div class="col-lg-4 col-md-6">
				<!-- Conatct Info Item Start -->
				<div class="contact-info-item wow fadeInUp" data-wow-delay="0.2s">
					<div class="icon-box">
						<img src="/frontend/images/icon-mail.svg" alt="Email">
					</div>
					<div class="contact-info-content">
						<h3>Email:</h3>
						<p><a href="mailto:{{$setting->email}}">{{$setting->email}}</a></p>
					</div>
				</div>
				<!-- Conatct Info Item End -->
			</div>

			<div class="col-lg-4 col-md-6">
				<!-- Conatct Info Item Start -->
				<div class="contact-info-item wow fadeInUp" data-wow-delay="0.4s">
					<div class="icon-box">
						<img src="/frontend/images/icon-phone.svg" alt="Phone">
					</div>
					<div class="contact-info-content">
						<h3>Số điện thoại:</h3>
						<p><a href="tel:{{$setting->phone1}}">{{$setting->phone1}}</a></p>
					</div>
				</div>
				<!-- Conatct Info Item End -->
			</div>
		</div>
	</div>
</div>
<!-- Page Contact Us End -->

<!-- Google Map & Contact Form Section Start -->
<div class="google-map-form">
	<div class="google-map">
		{!!$setting->iframe_map!!}
	</div>

	<div class="container">
		<div class="row">
			<div class="col-lg-6 offset-lg-6">
				<!-- Contact Form Box Start -->
				<div class="contact-form-box">
					<!-- Section Title Start -->
					<div class="section-title">
						<h3 class="wow fadeInUp">Liên hệ ngay</h3>
						<h2 class="text-anime-style-3" data-cursor="-opaque">Gửi thông tin cho chúng tôi</h2>
					</div>
					<!-- Section Title End -->

					<!-- Contact Form Start -->
					<form action="{{route('postcontact')}}" method="post" data-toggle="validator" class="wow fadeInUp" data-wow-delay="0.5s">
						@csrf
						<div class="row">
							<div class="form-group col-md-6 mb-4">
								<input type="text" name="name" class="form-control" placeholder="Họ tên" required>
								<div class="help-block with-errors"></div>
							</div>

							<div class="form-group col-md-6 mb-4">
								<input type="email" name ="email" class="form-control" placeholder="Email Address" required>
								<div class="help-block with-errors"></div>
							</div>
							
							<div class="form-group col-md-12 mb-4">
								<input type="text" name="phone" class="form-control" placeholder="Your Phone" required>
								<div class="help-block with-errors"></div>
							</div>

							<div class="form-group col-md-12 mb-5">
								<textarea name="message" class="form-control" rows="4" placeholder="Your Message"></textarea>
								<div class="help-block with-errors"></div>
							</div>

							<div class="col-lg-12">
								<div class="contact-form-btn">
									<button type="submit" class="btn-default">Gửi</button>
									<div id="msgSubmit" class="h3 hidden"></div>
								</div>
							</div>
						</div>
					</form>
					<!-- Contact Form End -->
				</div>
				<!-- Contact Form Box End -->
			</div>
		</div>
	</div>
</div>
@endsection