@extends('layouts.main.master')
@section('title')
{{$title}}
@endsection
@section('description')
Danh sách {{$title}}
@endsection
@section('image')
{{url(''.$banner[0]->image)}}
@endsection
@section('js')
@endsection
@section('css')
@endsection
@section('content')

<div class="our-mission-vision" style="padding-top: 0px;">
    <div class="mission-vision-bg parallaxie">
        <div class="container">
            <div class="row section-row align-items-center">
                <div class="col-lg-6">
                    <!-- Section Title Start -->
                    <div class="section-title dark-section">
                        <h3 class="wow fadeInUp">Product</h3>
                        <h2 data-cursor="-opaque">Sản phẩm của chúng tôi</h2>
                    </div>
                    <!-- Section Title End -->
                </div>
 
                <div class="col-lg-6">
                    <!-- Section Title Content Start -->
                    <div class="section-title-content dark-section wow fadeInUp" data-wow-delay="0.2s">
                        <p>Mang đến giải pháp cửa cuốn chống cháy toàn diện, giúp bảo vệ con người và tài sản trước nguy cơ cháy nổ.</p>
                    </div>
                    <!-- Section Title Content End -->
                </div>
            </div>
        </div>
    </div>
 
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Mission Vision Box Start -->
                <div class="mission-vision-box tab-content wow fadeInUp" data-wow-delay="0.25s" id="missionvision">
                    <!-- Sidebar Mission Vision Nav start -->
                    <div class="mission-vision-nav">
                        <ul class="nav nav-tabs" id="mvTab" role="tablist">
                         @foreach ($list as $key => $item)
                         <li class="nav-item" role="presentation">
                            <button class="nav-link {{($key == 0) ? 'active' : '' }}" id="remodeling-tab-{{$key}}" data-bs-toggle="tab" data-bs-target="#mission-{{$key}}" type="button" role="tab" aria-selected="true"><img src="/frontend/images/fire-shield-svgrepo-com.svg" alt=""> {{($item->name)}}</button>
                        </li>
                         @endforeach
                        </ul>
                    </div>
                     
                    <!-- Mission Vision Item Start -->
                    @foreach ($list as $key => $item)
                    @php
                        $imgpro = json_decode($item->images);
                    @endphp
                    <div class="mission-vision-item tab-pane fade  {{($key == 0) ? 'show active' : '' }}" id="mission-{{$key}}" role="tabpanel">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <!-- Mission Vision Content Start -->
                                <div class="mission-vision-content">
                                    {!!languageName($item->description)!!}   
                                    <div class="hero-btn wow fadeInUp mt-3" data-wow-delay="0.4s">
                                     <a href="{{route('detailProduct',['cate'=>$item->cate_slug,'type'=>$item->type_slug ? $item->type_slug : 'loai','id'=>$item->slug])}}" class="btn-default">Chi Tiết</a>
                                     <a href="tel:{{$setting->phone1}}" class="btn-default btn-highlighted">Liên Hệ</a>
                                  </div>                                 
                                </div>
                                <!-- Mission Vision Content End -->
                            </div>
 
                            <div class="col-lg-6">
                                <!-- Mission Vision Image Start -->
                                <div class="mission-vision-image">
                                    <figure  class="image-anime">
                                        <img src="{{url(''.$imgpro[0])}}" alt="{{$imgpro[0]}}">
                                    </figure>
                                </div>
                                <!-- Mission Vision Image End -->
                            </div>
                        </div>
                    </div>
                    <!-- Mission Vision Item End -->
                    @endforeach
                    
                </div>
                <!-- Mission Vision Box End -->
            </div>
        </div>
    </div>
 </div>

@endsection