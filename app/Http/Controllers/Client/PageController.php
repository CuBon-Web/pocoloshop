<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\product\Product;
use Session;
use App\models\product\Category;
use App\models\product\TypeProduct;
use DB,stdClass,File;
use App\models\District;
use Goutte\Client;
use App\models\blog\Blog;
use App\models\MessContact;
use App\models\Services;
use App\models\ServiceCate;
use App\models\website\Prize;
use App\models\website\Founder;
use App\models\website\Partner;
use App\models\PageContent;
use App\models\Project;
use App\models\Promotion;
use App\models\website\Video;
use App\Notifications\BillNotification;
use App\User;
use Mail;
use App\Mail\DemoMail;
use App\models\ReviewCus;
use App\models\website\AlbumAffter;
class PageController extends Controller
{
    public function sendmail(Request $request) {
       
    }
    public function orderNow()
    { 
        return view('orderNow');
    }
    public function baogia()
    {
        return view('baogia');
    }
    public function videoReview() {
        $data['video'] = Video::where('status',1)->paginate(20);
        return view('video',$data);
    }
    public function khuyenMai()  {
        $data['khuyenmai'] = Promotion::where('status',1)->paginate(12);
        return view('khuyenmai.list',$data);
    }
    public function detailKhuyenmai($slug) {
        $data['detail'] = Promotion::where('slug',$slug)->first();
        return view('khuyenmai.detail',$data);
    }
    public function menu()
    {
        
        $data['allproduct'] = Product::where([
            ['status', '=', 1]
        ])->limit(9)->orderBy('id','DESC')->get(['id','name','discount','price','images','slug']);
        $data['hotnews'] = Blog::where([
            ['status','=',1],
            ['type_news','=','tin-hot']
        ])->orderBy('id','DESC')->limit(7)->get(['id','title','slug','created_at','image']);
        return view('menu',$data);
    }
    public function quickview($id){
        $data['product'] = Product::with('cate')->where('id',$id)->first();
        return view('layouts.product.quickview',$data);
    }
    public function aboutUs(){
        $data['partner'] = Partner::where(['status'=>1])->get(['id','image','name','link']);
        $data['gioithieu'] = PageContent::where(['slug'=>'gioi-thieu','language'=>'vi'])->first(['id','title','content','image']);
        $data['taisao'] = AlbumAffter::where(['status'=>1])->get();
        $data['ReviewCus'] = ReviewCus::where(['status'=>1])->get();
        return view('aboutus',$data);
    }
    public function contact()
    {
        return view('contactus');
    }
    public function getPostInfor()
    {
        $data['category_product'] = Category::where('status',1)->get();
        return view('post_info.index',$data);
    }
    public function postPostInfor(Request $request,Product $product )
    {
        $data = $product->createClient($request);
        $data['category'] = Category::where(['status'=> 1])->orderBy('id','ASC')->get();
        $data['categoryFirst'] = Category::where(['status'=> 1])->orderBy('id','ASC')->first();
        $productNewFirstTab = Product::where([
            'category'=> $data['categoryFirst'] ? $data['categoryFirst']->id : 0,
            'status' => 0
        ])->with('customer')
        ->orderBy('id','ASC')
        ->limit(10)->get()->toArray();
        $data['productNewFirstTab'] = array_chunk($productNewFirstTab,2);
        return view('home',$data)->with('success','Tin của bạn đang được xét duyệt!');
    }
    public function typeproduct($id)
    {
        $arr = [];
        $data = TypeProduct::where('cate_id',$id)->get();
        $lang = Session::get('locale');
        foreach($data as $item){
            $obj = new stdClass();
            $obj->name = languageName($item->name);
            $obj->id = $item->id;
            $arr[] = $obj;
        }
        return response()->json([
    		'message' => 'get data Success',
    		'data'=> $arr
    	],200);
    }
    public function district($id)
    {
        $data = District::where('_province_id',$id)->get();
        return response()->json([
    		'message' => 'get data Success',
    		'data'=> $data
    	],200);
    }
    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $code = Session::get('locale');
        $arr = [];
        $arrb = [];
        $arrOpt = [];
        //search option
        $productOpt =  Product::with('cate')
        ->where('status',1)
        ->get()
        ->toArray();
        foreach($productOpt as $key => $item){
            $fielName = json_decode($item['name']);
            foreach($fielName as $i){
                if(strpos(strtolower(stripVN($i->content)), strtolower(stripVN($keyword))) !== false && $i->lang_code == $code){
                    array_push($arr,$productOpt[$key]);
                }
            }
        }
        $data['keyword'] = $request->keyword;
        $data['countproduct'] = count($arr);
        $data['resultPro'] = $arr;
        return view('search_result',$data);
    }
    public function postcontact(Request $request){
        $data = new MessContact();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        
        // Kết hợp mess và address nếu có
        $mess = $request->mess ?? '';
        if($request->address){
            $mess .= ($mess ? "\n" : '') . "Địa chỉ: " . $request->address;
        }
        if($request->note){
            $mess .= ($mess ? "\n" : '') . "Ghi chú: " . $request->note;
        }
        $data->mess = $mess;
        
        $data->save();
        if($data){
            return \Redirect::to('/')->with('success', 'Gửi tin thành công');
        }else{
            return back()->with('error', 'Gửi tin thất bại');
        }
        
    }
    public function serviceDetail($danhmuc, $slug)
    {
        $data['detail_service'] = Services::where(['slug'=>$slug,'cate_slug'=>$danhmuc])->first();
         $data['serviceLq'] = Services::where(['cate_slug'=>$danhmuc])->get();
        return view('servicedetail',$data);
    }
    public function serviceListAll()
    {
        return view('servicelistAll');
    }
    public function serviceList($slug)
    {
        $data['list'] = Services::where(['cate_slug'=>$slug,'status'=>1])->paginate(12);
        $data['cateService'] = ServiceCate::where('slug',$slug)->first();
        return view('servicelist',$data);
    }
    public function duanTieuBieu()
    {
        $data['duan'] = Project::with(['cateService'])->where('status',1)->paginate(12);
        return view('album',$data);
    }
    public function duanTieuBieuDetail($slug)
    {
        $data['detail'] = Project::where('slug',$slug)->first();
        $data['duan'] = Project::where('status',1)->orderBy('id',"DESC")->limit(6)->get();
        return view('detailProject',$data);
    }
    public function fag()
    {
        return view('faq');
    }
}
