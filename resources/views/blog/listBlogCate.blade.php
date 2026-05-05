@extends('layouts.main.master')
@section('title')
{{$title_page}} 
@endsection
@section('description')
{{$title_page}} 
@endsection
@section('image')
{{url(''.$banner[0]->image)}}
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
					<h1 data-cursor="-opaque">{{$title_page}}</h1>
					<nav class="wow fadeInUp">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{route('home')}}">Trang chủ</a></li>
							<li class="breadcrumb-item active" aria-current="page">{{$title_page}}</li>
						</ol>
					</nav>
				</div>
				<!-- Page Header Box End -->
			</div>
		</div>
	</div>
</div>
<div class="page-blog">
    <div class="container">
        <div class="row">
            @foreach ($blog as $key => $item)
            <div class="col-lg-4 col-md-6">
                <!-- Post Item Start -->
                <div class="post-item wow fadeInUp">
                    <!-- Post Featured Image Start-->
                    <div class="post-featured-image">
                        <a href="{{route('detailBlog',['slug'=>$item->slug])}}"  data-cursor-text="View">
                            <figure class="image-anime">
                                <img src="{{$item->image}}" alt="{{$item->title}}">                                
                            </figure>   
                        </a>                            
                    </div>
                    <!-- Post Featured Image End -->

                    <!-- post Item Body Start -->
                    <div class="post-item-body">
                        <!-- Post Item Content Start -->
                        <div class="post-item-content">
                            <h2><a href="{{route('detailBlog',['slug'=>$item->slug])}}">{{languageName($item->title)}}</a></h2>
                            <p class="line_2">{!!languageName($item->description)!!}</p>
                        </div>
                        <!-- Post Item Content End-->

                        <!-- Post Item Button Start-->
                        <div class="post-item-btn">
                            <a href="{{route('detailBlog',['slug'=>$item->slug])}}">Xem thêm</a>
                        </div>
                        <!-- Post Item Button End-->
                    </div>
                    <!-- post Item Body End -->
                </div>
                <!-- Post Item End -->
            </div>
            @endforeach
            <div class="col-lg-12">
                <!-- Page Pagination Start -->
                <div class="page-pagination wow fadeInUp" data-wow-delay="1.2s">
                    <ul class="pagination">
                        {{$blog->links()}}
                    </ul>
                </div>
                <!-- Page Pagination End -->
            </div>
        </div>
    </div>
</div>

@endsection