@extends('layouts.main.master')
@section('title')
{{languageName($blog_detail->title)}}
@endsection
@section('description')
{{languageName($blog_detail->description)}}
@endsection
@section('image')
{{url(''.$blog_detail->image)}}
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
					<h1 data-cursor="-opaque">{{languageName($blog_detail->title)}}</h1>
					<nav class="wow fadeInUp">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{route('home')}}">Trang chủ</a></li>
							<li class="breadcrumb-item"><a href="">Tin tức</a></li>
							<li class="breadcrumb-item active" aria-current="page">{{languageName($blog_detail->title)}}</li>
						</ol>
					</nav>
				</div>
				<!-- Page Header Box End -->
			</div>
		</div>
	</div>
</div>
<div class="page-single-post">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Post Featured Image Start -->
                <div class="post-image">
                    <figure class="image-anime reveal">
                        <img src="{{$blog_detail->image}}" alt="{{$blog_detail->title}}">
                    </figure>
                </div>
                <!-- Post Featured Image Start -->

                <!-- Post Single Content Start -->
                {!!languageName($blog_detail->content)!!}
                <!-- Post Single Content End -->
            </div>
        </div>
    </div>
</div>
@endsection