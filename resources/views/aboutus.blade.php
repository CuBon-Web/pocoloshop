@extends('layouts.main.master')
@section('title')
Về Chúng Tôi
@endsection
@section('description')
{{$setting->company}}
@endsection
@section('css')
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
					<h1  data-cursor="-opaque">{{$setting->company}}</h1>
					<nav class="wow fadeInUp">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="./">home</a></li>
							<li class="breadcrumb-item active" aria-current="page">about us</li>
						</ol>
					</nav>
				</div>
				<!-- Page Header Box End -->
			</div>
		</div>
	</div>
</div>
<div class="about-us page-about-us">
	<div class="container">
		<div class="row align-items-center">
			
			<div class="col-lg-12">
				<div class="about-us-content">
					<!-- Section Title Start -->
					<div class="section-title">
						<h3 class="wow fadeInUp">about us</h3>
						<h2  data-cursor="-opaque">{{($gioithieu->title)}}</h2>
						
					</div>
					<div class="wow fadeInUp" data-wow-delay="0.2s">{!!($gioithieu->content)!!}</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="our-services">
	<div class="container">
	   <div class="row section-row align-items-center">
		  <div class="col-lg-6">
			 <!-- Section Title Start -->
			 <div class="section-title">
				<h3 class="wow fadeInUp">our services</h3>
				<h2  data-cursor="-opaque">Tại sao nên chọn chúng tôi</h2>
			 </div>
			 <!-- Section Title End -->
		  </div>
		  <div class="col-lg-6">
			 <!-- Section Title Content Start -->
			 <div class="section-title-content">
				<p class="wow fadeInUp" data-wow-delay="0.2s">Tuy là doanh nghiệp trẻ nhưng Shield Door quy tụ đội ngũ kỹ thuật viên, chuyên gia nhiều năm kinh nghiệm trong lĩnh vực cửa cuốn công nghiệp và cửa cuốn chống cháy cao cấp. Kết hợp với hệ thống dây chuyền sản xuất hiện đại</p>
			 </div>
			 <!-- Section Title Content End -->
		  </div>
	   </div>
	   <div class="row align-items-center">
		 
			 <div class="col-lg-4 col-md-6 order-lg-1 order-md-1">
				<!-- Service Content Box Start -->
				<div class="service-content-box">
				   @foreach ($taisao as $key => $item)
				   @if ($key % 2 == 0)
				   <!-- Service Box Item Start -->
				   <div class="service-box-item wow fadeInUp" data-wow-delay="0.{{$key}}s">
					  <div class="icon-box">
						 <img src="{{url(''.$item->image)}}" alt="{{$item->image}}">
					  </div>
					  <div class="service-item-content">
						 <h3>{{$item->name}}</h3>
						 <p>{{$item->link}}</p>
					  </div>
				   </div>
				   <!-- Service Box Item End -->
				   @endif
				   
				   @endforeach
				  
				</div>
				<!-- Service Content Box End -->
			 </div>
			 
		  <div class="col-lg-4 order-lg-2 order-md-3">
			 <!-- Service Box Image Start -->
			 <div class="service-box-image">
				<img src="/frontend/images/service-img.png" alt="">
			 </div>
			 <!-- Service Box Image End -->
		  </div>
		  <div class="col-lg-4 col-md-6 order-lg-3 order-md-2">
			 <!-- Service Content Box Start -->
			 <div class="service-content-box">
				@foreach ($taisao as $key => $item)
				@if ($key % 2 != 0)
				<!-- Service Box Item Start -->
				<div class="service-box-item wow fadeInUp" data-wow-delay="0.{{$key}}s">
				   <div class="icon-box">
					  <img src="{{url(''.$item->image)}}" alt="{{$item->image}}">
				   </div>
				   <div class="service-item-content">
					  <h3>{{$item->name}}</h3>
					  <p>{{$item->link}}</p>
				   </div>
				</div>
				<!-- Service Box Item End -->
				@endif
				
				@endforeach
			 </div>
			 <!-- Service Content Box End -->
		  </div>
	   </div>
	</div>
 </div>

@endsection