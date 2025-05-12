<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


use function Laravel\Prompts\alert;

class AuthController extends Controller
{
    // public function login()
    // {
    //     return view('/clients.auth');
    // }

    public function doLogin(Request $request)
    {
        $param = $request->all();
        $checkLogin = Auth::attempt([
            'email'=> $param['email'], 
            'password' => $param['password']
        ]);
        if ($checkLogin) {
            // Check role for admin
            $user = Auth::user();
            session(['user_id' => $user->id]);
            $role = $user->role;
            if ($role == User::ROLE_ADMIN) {
                // role = 0 is customers
                return redirect('/admin/concept-category');
            } else if ($role == User::ROLE_STAFF) {
                // role = 1 is staff
                return redirect('/staff/work-schedule');
            }else{
  // role = 2 is admin
  return redirect('/clients/home');
            }
          
        } else {
            return redirect('/auth')->with('error', 'Email hoặc mật khẩu không đúng.');
        }
    }

    // public function getRegister ()
    // {
    //     return view('/clients.auth');
    // }

    public function postRegister(Request $request)
    {
        $param = $request->all();
        if ($param['password'] != $param['re_password']) {
            return redirect('/auth');
        }
        // Check email already exit's
        $checkEmail = User::where('email', $param['email'])->get();
        if (count($checkEmail) > 0) {
            return redirect('/auth');
        }
        $data = [
            'email' => $param['email'],
            'name' => $param['name'],
            'password' => Hash::make($param['password']),
            'role' => 2,
        ];
    
        try {
            // Chèn dữ liệu vào bảng users
            User::insert($data);
        } catch (\Exception $exception) {
            return redirect('/auth')->with('error', 'Đã xảy ra lỗi trong quá trình đăng ký!');
        }
        //Redirect to login page
        return redirect('/auth')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.')->with('showLogin', true);    
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/auth');
    }
}
