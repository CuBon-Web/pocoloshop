@extends('layouts.main.master')
@section('title')
Tất cả dịch vụ
@endsection
@section('description')
Tất cả dịch vụ
@endsection
@section('image')
{{url(''.$banner[0]->image)}}
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
					<h1 data-cursor="-opaque">Tất cả dịch vụ</h1>
					<nav class="wow fadeInUp">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{route('home')}}">Trang chủ</a></li>
							<li class="breadcrumb-item active" aria-current="page">Tất cả dịch vụ</li>
						</ol>
					</nav>
				</div>
				<!-- Page Header Box End -->
			</div>
		</div>
	</div>
</div>
<div class="work-gallery">
   <div class="container">
      <div class="row">
        @foreach ($servicehome as $key => $item)
         <div class="col-lg-4 col-md-6">
            <!-- Work Gallery Item Start -->
            <div class="work-gallery-item wow fadeInUp">
               <div class="work-gallery-img">
                  <a href="{{route('serviceList',['slug'=>$item->slug])}}" data-cursor-text="View">
                     <figure class="image-anime">
                        <img src="{{$item->image}}" alt="{{$item->name}}">
                     </figure>
                  </a>
               </div>
               <div class="work-gallery-content">
                  <h3><a href="{{route('serviceList',['slug'=>$item->slug])}}">{{$item->name}}</a></h3>
               </div>
            </div>
            <!-- Work Gallery Item End -->
         </div>
         @endforeach
      </div>
   </div>
</div>
@endsection