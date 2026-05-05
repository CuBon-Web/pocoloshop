@extends('layouts.main.master')
@section('title')
{{$cateService->name}}
@endsection
@section('description')
{{$cateService->description}}
@endsection
@section('image')
{{url(''.$banner[0]->image)}}
@endsection
@section('css')
@endsection
@section('js')
{{-- <script>
   $('.view_mores').on('click', 'a', function() {
	if( $(this).hasClass('one') ){
		$(this).addClass('d-none');
		$('.view_mores .two').removeClass('d-none');
	} else {
		$(this).addClass('d-none');
		$('.view_mores .one').removeClass('d-none');
	}
	$('.content_coll').toggleClass('active');
	$('.bg_cl').toggleClass('d-none');
});
</script> --}}
@endsection
@section('content')
<div class="page-header parallaxie">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-12">
				<!-- Page Header Box Start -->
				<div class="page-header-box">
					<h1 data-cursor="-opaque">{{($cateService->name)}}</h1>
					<nav class="wow fadeInUp">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{route('home')}}">Trang chủ</a></li>
							<li class="breadcrumb-item"><a href="{{route('serviceListAll')}}">Tất cả dịch vụ</a></li>
							<li class="breadcrumb-item active" aria-current="page">{{($cateService->name)}}</li>
						</ol>
					</nav>
				</div>
				<!-- Page Header Box End -->
			</div>
		</div>
	</div>
</div>
<div class="page-service-single">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <!-- Service Sidebar Start -->
                <div class="service-sidebar">
                    <!-- Service Category List Start -->
                    <div class="service-catagery-list wow fadeInUp">
                        <h3>Tất cả dịch vụ</h3>
                        <ul>
                            @foreach ($servicehome as $item)
                            <li><a href="{{route('serviceList',['slug'=>$item->slug])}}">{{$item->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Service Category List End -->

                    <!-- Sidebar CTA Box Start -->
                    <div class="sidebar-cta-box wow fadeInUp" data-wow-delay="0.2s">
                        <!-- Sidebar CTA Content Start -->
                        <div class="sidebar-cta-title">
                            <h2>Thông tin liên hệ</h2>
                        </div>
                        <!-- Sidebar CTA Content End -->

                        <!-- Sidebar CTA Contact Start -->
                        <div class="sidebar-cta-contact">
                            <!-- Sidebar CTA Contact Item Start -->
                            <div class="sidebar-cta-contact-item">
                                <div class="icon-box">
                                    <img src="/frontend/images/icon-location.svg" alt="">
                                </div>

                                <div class="cta-contact-item-content">
                                    <p>{{$setting->address1}}</p>
                                </div>
                            </div>
                            <!-- Sidebar CTA Contact Item Start -->

                            <!-- Sidebar CTA Contact Item Start -->
                            <div class="sidebar-cta-contact-item">
                                <div class="icon-box">
                                    <img src="/frontend/images/icon-phone.svg" alt="">
                                </div>

                                <div class="cta-contact-item-content">
                                    <p>{{$setting->phone1}}</p>
                                </div>
                            </div>
                            <!-- Sidebar CTA Contact Item Start -->
                            
                            <!-- Sidebar CTA Contact Item Start -->
                            <div class="sidebar-cta-contact-item">
                                <div class="icon-box">
                                    <img src="/frontend/images/icon-mail.svg" alt="">
                                </div>

                                <div class="cta-contact-item-content">
                                    <p>{{$setting->email}}</p>
                                </div>
                            </div>
                            <!-- Sidebar CTA Contact Item Start -->
                        </div>
                        <!-- Sidebar CTA Contact End -->
                    </div>
                    <!-- Sidebar CTA Box End -->
                </div>
                <!-- Service Sidebar End -->
            </div>

            <div class="col-lg-8">
                <!-- Service Single Content Start -->
                <div class="servics-single-content">

                    <!-- Secvice Entry Start -->
                    <div>
                        {!!($cateService->content)!!}
                       </div>
                    <!-- Secvice Entry End -->
                </div>
                <!-- Service Single Content End -->
            </div>
        </div>
    </div>
</div>
@endsection