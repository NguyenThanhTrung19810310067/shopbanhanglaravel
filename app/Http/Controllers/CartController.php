<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Cart;
use Gloudemans\Shoppingcart\Cart as ShoppingcartCart;
use Gloudemans\Shoppingcart\Facades\Cart as FacadesCart;

class CartController extends Controller
{
    public function save_cart(Request $request){
        
        $productId = $request->productid_hiden;
        $quantity = $request->quanty;
        $product_info= DB::table('tbl_product')->where('product_id',$productId)->first();
        // Cart::add('293ad', 'Product 1', 1, 9.99, 550);
        $data['id']=$product_info->product_id;
        $data['qty']=$quantity;
        $data['name']=$product_info->product_name;
        $data['price']=$product_info->product_price;
        $data['weight']='1';
        $data['options']['image']=$product_info->product_image;
        Cart::add($data);
        Cart::setGlobalTax(10);
        return Redirect::to('/show-cart');
    }
    public function show_cart(){
        $cate_product= DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product= DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();
        return view('pages.cart.show_cart')->with('category',$cate_product)->with('brand',$brand_product);
    }
    public function delete_to_cart($rowId){
        Cart::update($rowId,0);
        return Redirect::to('/show-cart');
    }
    public function update_cart_quantity(Request $request){
        $rowId = $request->rowId_cart;
        $quantity = $request->cart_quantity;
        Cart::update($rowId,$quantity);
        return Redirect::to('/show-cart');
    }
}
