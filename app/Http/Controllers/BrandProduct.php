<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class BrandProduct extends Controller
{
    public function AthLogin(){
        $admin_id= session()->get('admin_id');
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }
    public function add_brand_product(){
        $this->AthLogin();
        return view('admin.add_brand_product');
    }
    public function all_brand_product(){
        $this->AthLogin();
        $all_brand_product= DB::table('tbl_brand')->get();
        $manager_brand_product = view('admin.all_brand_product')->with('all_brand_product',$all_brand_product);
        return view('admin_layout')->with('admin.all_brand_product',$manager_brand_product);
    }
    public function save_brand_product(Request $request){
        $this->AthLogin();
        $data = array();
        $data['brand_name'] = $request->brand_product_name; //ten cua input gui data
        $data['brand_desc'] = $request->brand_product_desc;
        $data['brand_status'] = $request->brand_product_status;
        DB::table('tbl_brand')->insert($data);
        $request->session()->put('messenge','thêm thương hiệu sản phẩm thành công');
        return Redirect::to('/add-brand-product');
    }
    public function active_brand_product($brand_product_id){
        $this->AthLogin();
        DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update(['brand_status'=>1]);
        session()->put('messenge','Hiện thị thương hiệu sản phẩm thành công');
        return Redirect::to('/all-brand-product');
    }
    public function unactive_brand_product($brand_product_id){
        $this->AthLogin();
        DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update(['brand_status'=>0]);
        session()->put('messenge','Ẩn thương hiệu sản phẩm thành công');
        return Redirect::to('/all-brand-product');
    }
    public function edit_brand_product($brand_product_id){
        $this->AthLogin();
        $edit_brand_product= DB::table('tbl_brand')->where('brand_id',$brand_product_id)->get();
        $manager_brand_product = view('admin.edit_brand_product')->with('edit_brand_product',$edit_brand_product);
        return view('admin_layout')->with('admin.edit_brand_product',$manager_brand_product);
    }
    public function update_brand_product(Request $request,$brand_product_id){
        $this->AthLogin();
        $data =array();
        $data['brand_name'] = $request->brand_product_name; //ten cua input gui data
        $data['brand_desc'] = $request->brand_product_desc;
        DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update($data);
        session()->put('messenge','Cập nhật thương hiệu sản phẩm thành công');
        return Redirect::to('/all-brand-product');
    }
    public function delete_brand_product($brand_product_id){
        $this->AthLogin();
        DB::table('tbl_brand')->where('brand_id',$brand_product_id)->delete();
        session()->put('messenge','Xóa thương hiệu sản phẩm thành công');
        return Redirect::to('/all-brand-product');
    }
    //end func admin page
    public function show_brand_home($brand_id){
        $cate_product= DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product= DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();
        $brand_by_id=DB::table('tbl_product')->join('tbl_brand','tbl_product.brand_id','=','tbl_brand.brand_id')->where('tbl_product.brand_id',$brand_id)->get();
        $brand_name=DB::table('tbl_brand')->where('tbl_brand.brand_id',$brand_id)->get();
        return view('pages.brand.show_brand')->with('category',$cate_product)->with('brand',$brand_product)->with('brand_by_id',$brand_by_id)->with('brand_name',$brand_name);
    }
}
