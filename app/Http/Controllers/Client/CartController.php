<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\product\Product;
use Cart,Auth,Redirect,DB;
use App\models\Bill\BillDetail;
use App\models\Bill\Bill;
use Mail;
use App\Mail\DemoMail;

class CartController extends Controller
{
    public function checkout(){
            $data['cart'] = session()->get('cart', []);
            $data['profile'] = Auth::guard('customer')->user();
            return view('cart.checkout',$data);
        
    }
    public function postBill(Request $request){
        $profile = Auth::guard('customer')->user();
        $cart = session()->get('cart', []);
        $code_bill = rand();
        DB::beginTransaction();
			try {
				$query = new Bill();
				$query->code_bill = $code_bill;
				$query->code_customer = $profile ? $profile->id : 0;
				$query->total_money = $request->total_money;
				$query->statu = 0;
				$query->note = $request->note;
                $query->cus_name = $request->billingName;
                $query->cus_phone = $request->billingPhone;
                $query->cus_email= $request->billingEmail;
                $query->cus_address= $request->billingAddress;
                $query->transport_price = $request->shippingMethod ? $request->shippingMethod : 0;
				$query->save();
                
					
                foreach($cart as $key => $item){
                    $billdetail = new BillDetail();
                    $billdetail->code_bill = $code_bill;
                    $billdetail->code_product = $item['idpro'];
                    $billdetail->name =$item['name'];
                    if($item['status_variant'] == 1){
                        $billdetail->price = $item['price'];
                    }else{
                        if($item['discount'] > 0){
                            $billdetail->price = $item['discount'];
                        }else{
                            $billdetail->price = $item['price'];
                        }
                    }
                    $billdetail->qty = $item['quantity'];
                    $billdetail->images = $item['image'];
                    $billdetail->variant = $item['status_variant'] == 1 ? $item['variant'] : '';
                    $billdetail->save();

                    $product = Product::find($item['idpro']);
                    if($product->qty > $billdetail->qty){
                        $product->qty = $product->qty - $billdetail->qty;
                        $product->save();
                    }else{
                        $product->qty = 0;
                        $product->save();
                    }
                    
                }
				DB::commit();
                $data = ['cus' => $query,'bill'=>$cart];
                Mail::to('muadogo.vn@gmail.com')->send(new DemoMail($data));
                $request->session()->forget('cart');
             return view('cart.orderSuccess');
			} catch (\Throwable $e) {
			DB::rollBack();
			throw $e;
                return back()->with('error','Gửi đơn hàng thất bại');
			}
    }
    public function listCart(){
        $data['cart'] = session()->get('cart', []);
        return view('cart.list',$data);
    }
    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $cart = session()->get('cart', []);
        

        if(isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = $cart[$request->product_id]['quantity'] + $request->quantity;
        } else {
            $cart[$request->product_id] = [
                "idpro" => $request->product_id,
                "name" => $product->name,
                "variant"=>$request->variant,
                "quantity" => $request->quantity,
                "price" => $request->price == 0 ? $product->price : $request->price,
                'status_variant' => $product->status_variant,
                "discount" => $product->discount,
                "image" => json_decode($product->images)[0]
            ];
        }
        session()->put('cart', $cart);
        return response()->json($cart);
    }
    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            return response()->json($cart);
        }
        
    }
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return response()->json($cart);
        }
    }
    public function orderSuccess()
    {
        return view('cart.orderSuccess');
    }
}
