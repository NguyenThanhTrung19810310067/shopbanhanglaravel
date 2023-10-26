<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Redirect;
session_start();
class AdminController extends Controller
{
    public function AthLogin(){
        $admin_id= session()->get('admin_id');
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }
    public function index(){
        return view('admin_login');
    }
    public function show_dashboard(){
        $this->AthLogin();
        return view('admin.dashboard');
    }
    public function dashboard(Request $request){
        $admin_email = $request->admin_email;
        $admin_password = md5($request->admin_password); //$->name thẻ

        $result= DB::table('tbl_admin')->where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
        if($result){
            $request->session()->put('admin_name', $result->admin_name);
            $request->session()->put('admin_id', $result->admin_id);
            return Redirect::to('/dashboard');
        }else{
            $request->session()->put('messenge','Tài khoản mật khẩu không đúng!');
            return Redirect::to('/admin');
        }
    }
    public function log_out(){
        $this->AthLogin();
        session()->put('admin_name',null);
        session()->put('admin_id',null);
        return Redirect::to('/admin');
    }
}
