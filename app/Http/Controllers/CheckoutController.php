<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;


class checkoutController extends Controller
{
    public function login_checkout(){
        $cate_product= DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product= DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();
        return view('pages.checkout.login_checkout')->with('category',$cate_product)->with('brand',$brand_product);
    }
    public function add_customer(Request $request){
        $data=array();
        $data['customer_name']=$request->customer_name;
        $data['customer_email']=$request->customer_email;
        $data['customer_password']=md5($request->customer_password);
        $data['customer_phone']=$request->customer_phone;

        $customer_id=DB::table('tbl_customers')->insertGetId($data);
        $request->session()->put('customer_id', $customer_id);
        $request->session()->put('customer_name', $request->customer_name);
        return redirect::to('checkout');
    }
    public function checkOut(){
        $cate_product= DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product= DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();
        return view('pages.checkout.show_checkout')->with('category',$cate_product)->with('brand',$brand_product);
    }
    public function save_checkout_customer(Request $request){
        $data=array();
        $data['shipping_name']=$request->shipping_name;
        $data['shipping_email']=$request->shipping_email;
        $data['shipping_address']=$request->shipping_address;
        $data['shipping_phone']=$request->shipping_phone;
        $data['shipping_note']=$request->shipping_note;

        $shipping_id=DB::table('tbl_shipping')->insertGetId($data);
        $request->session()->put('shipping_id', $shipping_id);
        return redirect::to('payment');
    }
    public function payment(){
        $cate_product= DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand_product= DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();
        return view('pages.checkout.payment')->with('category',$cate_product)->with('brand',$brand_product);
    }
    public function order_place(Request $request){
        //insert payment method
        $data=array();
        $data['payment_method']=$request->payment_option;
        $data['payment_status']='Đang chờ xử lý';
        $payment_id=DB::table('tbl_payment')->insertGetId($data);
        if($data['payment_method']==1){
            echo'Thanh toán bằng thẻ ATM';
        }elseif($data['payment_method']==2){
        //insert order
        $order_data=array();
        $order_data['customer_id']=$request->session()->get('customer_id');
        $order_data['shipping_id']=$request->session()->get('shipping_id');
        $order_data['payment_id']=$payment_id;
        $order_data['order_total']=Cart::total();
        $order_data['order_status']='Đang chờ xử lý';
        $order_id=DB::table('tbl_order')->insertGetId($order_data);
        //insert order detail
        $content= Cart::content();
        foreach($content as $v_conntent){
            $order_d_data=array();
            $order_d_data['order_id']=$order_id;
            $order_d_data['product_id']=$v_conntent->id;
            $order_d_data['product_name']=$v_conntent->name;
            $order_d_data['product_price']=$v_conntent->price;
            $order_d_data['product_sales_quantity']=$v_conntent->qty;
            DB::table('tbl_order_details')->insert($order_d_data);
        }
            Cart::destroy();
            $cate_product= DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
            $brand_product= DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();
            return view('pages.checkout.handcash')->with('category',$cate_product)->with('brand',$brand_product);
        }else{
            
            // $content= Cart::content();
            // foreach($content as $val){
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = "http://localhost/shopbanhanglaravel/payment";
            $vnp_TmnCode = "5PYVTA1J";//Mã website tại VNPAY 
            $vnp_HashSecret = "ZTOTSPJESNMNFBIHCZMGHPUPSFCOHKJC"; //Chuỗi bí mật

            $vnp_TxnRef = rand(); //$_POST['order_id'] Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
            $vnp_OrderInfo = 11; //$_POST['order_desc']
            $vnp_OrderType = 130000;
            // $vnp_Amount = $val->price*$val->qty * 100; //$_POST['amount']
            $vnp_Locale = 'vn';
            $vnp_BankCode = 'NCB';
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
            //Add Params of 2.0.1 Version
            // $vnp_ExpireDate = $_POST['txtexpire'];
            //Billing
            
            
            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => Cart::total(0,'','') *100,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
                // "vnp_ExpireDate"=>$vnp_ExpireDate,
                // "vnp_Bill_Mobile"=>$vnp_Bill_Mobile,
                // "vnp_Bill_Email"=>$vnp_Bill_Email,
                // "vnp_Bill_FirstName"=>$vnp_Bill_FirstName,
                // "vnp_Bill_LastName"=>$vnp_Bill_LastName,
                // "vnp_Bill_Address"=>$vnp_Bill_Address,
                // "vnp_Bill_City"=>$vnp_Bill_City,
                // "vnp_Bill_Country"=>$vnp_Bill_Country,
                // "vnp_Inv_Phone"=>$vnp_Inv_Phone,
                // "vnp_Inv_Email"=>$vnp_Inv_Email,
                // "vnp_Inv_Customer"=>$vnp_Inv_Customer,
                // "vnp_Inv_Address"=>$vnp_Inv_Address,
                // "vnp_Inv_Company"=>$vnp_Inv_Company,
                // "vnp_Inv_Taxcode"=>$vnp_Inv_Taxcode,
                // "vnp_Inv_Type"=>$vnp_Inv_Type
            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
                $inputData['vnp_Bill_State'] = $vnp_Bill_State;
            }

            //var_dump($inputData);
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            $returnData = array('code' => '00'
                , 'message' => 'success'
                , 'data' => $vnp_Url);
                if (isset($_POST['redirect'])) {
                    //insert order
                    $order_data=array();
                    $order_data['customer_id']=$request->session()->get('customer_id');
                    $order_data['shipping_id']=$request->session()->get('shipping_id');
                    $order_data['payment_id']=$payment_id;
                    $order_data['order_total']=Cart::total();
                    $order_data['order_status']='Đang chờ xử lý';
                    $order_id=DB::table('tbl_order')->insertGetId($order_data);
                    //insert order detail
                    $content= Cart::content();
                    foreach($content as $v_conntent){
                        $order_d_data=array();
                        $order_d_data['order_id']=$order_id;
                        $order_d_data['product_id']=$v_conntent->id;
                        $order_d_data['product_name']=$v_conntent->name;
                        $order_d_data['product_price']=$v_conntent->price;
                        $order_d_data['product_sales_quantity']=$v_conntent->qty;
                        DB::table('tbl_order_details')->insert($order_d_data);
                    }
                    header('Location: ' . $vnp_Url);
                    die();
                } else {
                    echo json_encode($returnData);
                }
                // vui lòng tham khảo thêm tại code demo
                
// Ngân hàng	NCB
// Số thẻ	9704198526191432198
// Tên chủ thẻ	NGUYEN VAN A
// Ngày phát hành	07/15
                
        }
        
        return redirect::to('payment');
    }
    public function logout_checkout(Request $request){
        $request->session()->flush();
        return redirect::to('login-checkout');
    }
    public function login_customer(Request $request){
        $email=$request->email_account;
        $password=md5($request->password_account);
        $result = DB::table('tbl_customers')->where('customer_email',$email)->where('customer_password',$password)->first();
        if($result){
            $request->session()->put('customer_id', $result->customer_id);
            return redirect::to('checkout');
        }
        else{
            return redirect::to('login-checkout');
        }
    }
    public function AthLogin(){
        $admin_id= session()->get('admin_id');
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }
    public function manage_order(){
        $this->AthLogin();
        $all_order= DB::table('tbl_order')
        ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
        ->select('tbl_order.*','tbl_customers.customer_name')->orderBy('tbl_order.order_id','desc')->get();
        $manager_order = view('admin.manage_order')->with('all_order',$all_order);
        return view('admin_layout')->with('admin.manage_order',$manager_order);
    }
    public function view_order($orderId){
        $this->AthLogin();
        $order_by_id= DB::table('tbl_order')
        ->join('tbl_customers','tbl_order.customer_id','=','tbl_customers.customer_id')
        ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        ->join('tbl_order_details','tbl_order.order_id','=','tbl_order_details.order_id')
        ->select('tbl_order.*','tbl_customers.*','tbl_shipping.*','tbl_order_details.*')->where('tbl_order.order_id', $orderId)->get();
        $manager_order_by_id = view('admin.view_order')->with('order_by_id',$order_by_id);
        return view('admin_layout')->with('admin.view_order',$manager_order_by_id);
    }
}
