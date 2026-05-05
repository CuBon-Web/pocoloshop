
@php
$img = json_decode($pro->images);
@endphp

<div class="item">
    <div class="position-re o-hidden"> 
       <a href="{{route('detailProduct',['cate'=>$pro->cate_slug,'type'=>$pro->type_slug ? $pro->type_slug : 'loai','id'=>$pro->slug])}}" class="w-100">
         <img class="lazy" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC" data-src="{{$img[0]}}" alt="{{$img[0]}}"> 
      </a>
    </div>
    <div class="con text-center">
       <h5 style="margin-bottom:10px;"><a href="{{route('detailProduct',['cate'=>$pro->cate_slug,'type'=>$pro->type_slug ? $pro->type_slug : 'loai','id'=>$pro->slug])}}" class="line_1">{{$pro->name}}</a></h5>
       {{-- @if ($pro->price > 0)
            @if ($pro->status_variant == 1)
            <span>{{get_price_variant($pro->id)}}₫ <del>{{number_format($pro->price)}}₫</del></span>
            @else 
            <span>{{number_format($pro->discount)}}₫ <del>{{number_format($pro->price)}}₫</del></span>
            @endif
            
         @else
         <span>Liên Hệ</span>
         @endif --}}
    </div>
 </div>