@extends('layouts.main.master')
@section('title')
Dự án tiêu biểu
@endsection
@section('description')
Dự án tiêu biểu
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
					<h1 data-cursor="-opaque">Dự án tiêu biểu</h1>
					<nav class="wow fadeInUp">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{route('home')}}">Trang chủ</a></li>
							<li class="breadcrumb-item active" aria-current="page">Dự án tiêu biểu</li>
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
         @foreach ($duan as $key => $item)
         @php
             $imgduan = json_decode($item->images);
         @endphp
          <div class="col-lg-4 col-md-6">
             <!-- Work Gallery Item Start -->
             <div class="work-gallery-item wow fadeInUp">
                <div class="work-gallery-img">
                   <a href="{{route('duanTieuBieuDetail',['slug'=>$item->slug])}}" data-cursor-text="View">
                      <figure class="image-anime">
                         <img src="{{url(''.$imgduan[0])}}" alt="{{$imgduan[0]}}">
                      </figure>
                   </a>
                </div>
                <div class="work-gallery-content">
                   <h3><a href="{{route('duanTieuBieuDetail',['slug'=>$item->slug])}}">{{$item->name}}</a></h3>
                </div>
             </div>
             <!-- Work Gallery Item End -->
          </div>
          @endforeach
          {{ $duan->links() }}
       </div>
    </div>
 </div>
@endsection

