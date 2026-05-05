@extends('layouts.main.master')
@section('title')
{{$pagecontentdetail->title}}
@endsection
@section('description')
{{$pagecontentdetail->title}}
@endsection
@section('image')
{{url(''.$banner[0]->image)}}
@endsection
@section('css')
@endsection
@section('js')
@endsection
@section('content')
<div class="page-content">
	<!-- INNER PAGE BANNER -->
	<div class="sx-bnr-inr overlay-wraper bg-parallax bg-top-center" data-stellar-background-ratio="0.5" style="background-image: url(&quot;{{url('frontend/images/9.jpg')}}&quot;); background-position: 50% -50px;">
	   <div class="overlay-main bg-black opacity-07"></div>
	   <div class="container">
		  <div class="sx-bnr-inr-entry">
			 <div class="banner-title-outer">
				<div class="banner-title-name">
				   <h1 class="m-tb0">{{$pagecontentdetail->title}} </h1>
				</div>
			 </div>
			 <!-- BREADCRUMB ROW -->                            
			 <div>
				<ul class="sx-breadcrumb breadcrumb-style-2">
				   <li><a href="{{route('home')}}">Home</a></li>
				   <li>{{$pagecontentdetail->title}} </li>
				</ul>
			 </div>
			 <!-- BREADCRUMB ROW END -->                        
		  </div>
	   </div>
	</div>
	<!-- INNER PAGE BANNER END -->
	<div class="section-full p-t80 p-b50 inner-page-padding">
      <div class="container">
         <div class="blog-single-space max-w900 ml-auto mr-auto">
            <!-- BLOG START --> 
            <div class="blog-post blog-detail text-black">
               <div class="sx-post-title ">
                  <h3 class="post-title">{{$pagecontentdetail->title}}</h3>
               </div>
               <div class="sx-post-text">
                  {!!$pagecontentdetail->content!!}
               </div>
            </div>
            <!-- OUR BLOG START -->
           
         </div>
      </div>
   </div>
	<!-- CONTENT END -->
</div>
@endsection