<?php

namespace App\Http\Controllers\Api\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\product\Product;
use App\models\tag\TagCate;
use App\models\VariantSkuValue;
use DB;
use App\Services\CloudflareImageService;

class ProductController extends Controller
{
    protected $apiToken;
    protected $accountId;
    protected $cloudflareService;

    public function __construct(CloudflareImageService $cloudflareService)
    {
        $this->cloudflareService = $cloudflareService;
    }
    public function listVariantSku($id)
    {
        $data = VariantSkuValue::where('product_id',$id)->get();
        return response()->json([
            'data' => $data,
            'message' => 'success'
        ]);
    }
    public function listTags($id)
    {
        $data = TagCate::with(['tags'])->where([
            'cate_product_id'=> $id
        ])
        ->get();
        return response()->json([
            'data' => $data,
            'message' => 'success'
        ]);
    }
    public function create(Request $request, Product $product)
    {
        $data = $product->createOrEdit($request);
        return response()->json([ 'data' => $data, 'message' => 'success'], 200);
    }
    public function list(Request $request)
    {
        $keyword = $request->keyword;
        if($keyword == ""){
            $data = Product::leftJoin('product_category', function($join){
                $join->on('product_category.id','=','products.category');
            })
            ->select('products.*','product_category.name as cate')->orderBy('id','DESC')
            ->get();
        }else{
            $data = Product::where('products.name', 'LIKE', '%'.$keyword.'%')
            ->leftJoin('product_category', function($join){
                $join->on('product_category.id','=','products.category');
            })
            ->select('products.*','product_category.name as cate')->orderBy('id','DESC')
            ->get()->toArray();
        }
        return response()->json([
            'data' => $data,
            'message' => 'success'
        ]);
    }
    public function edit($id)
    {
        $data = Product::where([
            'id'=> $id
        ])
        ->first();
        return response()->json([
            'data' => $data,
            'message' => 'success'
        ]);
    }
    public function delete($id)
    {
       

        $query = Product::where(['id'=>$id])
        ->first();
        $arrimg = json_decode($query->images);
        foreach($arrimg as $url){
            $this->cloudflareService->deleteImage($url);
        }

       
        VariantSkuValue::where('product_id',$query->id)->delete();
        $query->delete();
       
        return response()->json([
            'message' => 'Delete success'
        ]); 
    }
}
