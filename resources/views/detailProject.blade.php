@extends('layouts.main.master')
@section('title')
{{$detail->name}}
@endsection
@section('description')
{{$detail->description}}
@endsection
@section('image')
@php
$img = json_decode($detail->images);
@endphp
{{url(''.$img[0])}}
@endsection
@section('js')
@endsection
@section('css')
@endsection
@section('content')
<div class="page-header parallaxie">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-12">
				<!-- Page Header Box Start -->
				<div class="page-header-box">
					<h1 data-cursor="-opaque">{{$detail->name}}</h1>
					<nav class="wow fadeInUp">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{route('home')}}">Trang chủ</a></li>
							<li class="breadcrumb-item"><a href="{{route('duanTieuBieu')}}">Dự án tiêu biểu</a></li>
							<li class="breadcrumb-item active" aria-current="page">{{$detail->name}}</li>
						</ol>
					</nav>
				</div>
				<!-- Page Header Box End -->
			</div>
		</div>
	</div>
</div>
<div class="page-project-single">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <!-- Project Sidebar Start -->
                <div class="project-single-sidebar">
                    <!-- Project Detail List Start -->
                    <div class="project-detail-list wow fadeInUp">
                        <div class="project-detail-title">
                            <h3>Thông tin dự án</h3>
                        </div>
                        <!-- Project Detail Item Start -->
                        <div class="project-detail-item">
                            <div class="icon-box">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div class="project-detail-content">
                                <h3>Vị Trí:</h3>
                                <p>{{$detail->location}}</p>
                            </div>
                        </div>
                        <!-- Project Detail Item End -->

                        <!-- Project Detail Item Start -->
                        <div class="project-detail-item">
                            <div class="icon-box">
                                <i class="fa-regular fa-circle-check"></i>
                            </div>
                            <div class="project-detail-content">
                                <h3>Quy mô:</h3>
                                <p>{{$detail->scale}}</p>
                            </div>
                        </div>
                        <!-- Project Detail Item End -->

                        <!-- Project Detail Item Start -->
                        <div class="project-detail-item">
                            <div class="icon-box">
                                <i class="fa-regular fa-calendar"></i>
                            </div>
                            <div class="project-detail-content">
                                <h3>Ngày bàn giao:</h3>
                                <p>{{$detail->operate}}</p>
                            </div>
                        </div>
                    </div>

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
                <!-- Project Sidebar End -->
            </div>

            <div class="col-lg-8">
                <!-- Project Single Content Start -->
                <div class="project-single-content">
                   

                    <!-- Project Entry Start -->
                    <div class="project-entry">
                        <!-- Project Gallery Images Start -->
                        <div class="project-gallery gallery-items mb-3">
                            <h2 class="text-anime-style-3">Hình ảnh dự án</h2>

                            <div class="project-gallery-images">
                                <!-- Project Gallery img Start -->
                                @foreach ($img as $item)
                                    <div class="project-gallery-img wow fadeInUp" data-cursor-text="View">
                                        <a href="{{url(''.$item)}}">
                                            <figure class="image-anime reveal">
                                                <img src="{{url(''.$item)}}" alt="">
                                            </figure>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- Project Gallery Images End -->
                        <!-- Project Information Start -->
                        <div class="project-info">
                        {!!languageName($detail->content)!!}
                        </div>
                        <!-- Project Information End -->


                        
                    </div>
                    <!-- Project Entry End -->
                </div>
                <!-- Project Single Content End -->
            </div>
        </div>
    </div>
</div>
@endsection