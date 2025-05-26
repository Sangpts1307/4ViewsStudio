<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\MailResgister;
use App\Models\User;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use function Laravel\Prompts\alert;

class AuthController extends Controller
{
    public function login()
    {
        session(['showLogin' => false]);
        return view('clients.auth');
    }


    public function doLogin(Request $request)
    {
        $param = $request->all();
        // attempt tự động kiểm tra email và mật khẩu 
        $checkLogin = Auth::attempt([
            'email' => $param['email'],
            'password' => $param['password']
        ]);
        if ($checkLogin) {
            // Check role for admin
            $user = Auth::user();
            session(['user_id' => $user->id]);
            $role = $user->role;
            if ($role == User::ROLE_ADMIN) {
                return redirect('/admin/concept-category');
            } else if ($role == User::ROLE_STAFF) {
                return redirect('/staff/work-schedule');
            } else if ($role == User::ROLE_CLIENT) {
                return redirect('/clients/home');
            }
        } else {
            return redirect('/login')->with('error', 'Email hoặc mật khẩu không đúng.');
        }
    }


    public function getRegister()
    {
        session(['showLogin' => true]);
        return view('clients.auth');
    }


    public function postRegister(Request $request)
    {
        $param = $request->all();
        // Kiểm tra xem có đang xác minh mã hay không
        if ($request->input('action') === 'verify') {
            // ✅ Bước xác minh mã
            if ($param['verification_code'] != session('verify_code')) {
                return redirect('/register')->with('error', 'Mã xác nhận không đúng')->with('singup', true);
            }
            // Lưu người dùng vào DB
            $data = [
                'email' => session('temp_user_data')['email'],
                'name' => session('temp_user_data')['name'],
                'password' => Hash::make(session('temp_user_data')['password']),
                'role' => User::ROLE_CLIENT,
            ];
            User::create($data);
            // Xoá session
            session()->forget(['verify_code', 'temp_user_data', 'singup']);
            return redirect('/login')->with('success', 'Đăng ký thành công, vui lòng đăng nhập');
        }
        // ✅ Bước đăng ký
        if ($param['password'] != $param['re_password']) {
            // session(['showLogin' => true]);
            return redirect('/register')->with('error', 'Mật khẩu không khớp');
        }
        // Kiểm tra xem email đã tồn tại chưa
        $checkEmail = User::where('email', $param['email'])->exists();
        if ($checkEmail) {
            return redirect('/register')->with('error', 'Email đã tồn tại');
        }
        try {
            $verifyCode = rand(100000, 999999);  // Tạo mã xác minh
            // Gửi email xác minh
            $mail = new MailResgister();
            $mail->setEmail($param['email']);
            $mail->setName($param['name']);
            $mail->setVerifyCode($verifyCode);
            Mail::to($param['email'])->send($mail);
            session([
                'verify_code' => $verifyCode,
                'temp_user_data' => $param,
                'singup' => true
            ]);
            return redirect('/register')->with('singup', true);
        } catch (\Exception $exception) {
            return redirect('/register')->with('error', 'Lỗi gửi email xác nhận');
        }
    }





    public function forgotPassword()
    {
        return view('clients.forgot');
    }

    public function postForgotPassword(Request $request)
    {
        $param = $request->all();
        $action = $param['action'] ?? 'send_code';
        // Kiểm tra xem có đang xác minh mã hay không
        if ($action === 'send_code') {
            $user = User::where('email', $param['email'])->first();
            if (!$user) {
                return redirect('/forgot')->with('error', 'Email không tồn tại');
            }
            $verifyCode = rand(100000, 999999);
            try {
                $mail = new MailResgister();
                $mail->setEmail($param['email']);
                $mail->setVerifyCode($verifyCode);
                Mail::to($param['email'])->send($mail);
                session([
                    'forgot' => true,
                    'temp_user_data' => ['email' => $param['email']],
                    'verify_code' => $verifyCode
                ]);
                return redirect('/forgot')->with('success', 'Mã xác nhận đã được gửi đến email của bạn');
            } catch (\Exception $e) {
                return redirect('/forgot')->with('error', 'Không thể gửi mã xác nhận. Vui lòng thử lại.');
            }
        }
        // Xử lý các hành động xác minh và đặt lại mật khẩu
        if ($action === 'verify') {
            if ($param['verification_code'] != session('verify_code')) {
                return redirect('/forgot')->with('error', 'Mã xác nhận không đúng');
            }
            session()->forget('verify_code');
            session(['new_password' => true]);
            return redirect('/forgot')->with('success', 'Xác minh thành công. Vui lòng đặt mật khẩu mới');
        }
        // Xử lý đặt lại mật khẩu
        if ($action === 'reset_password') {
            if ($param['new_password'] !== $param['re_new_password']) {
                return redirect('/forgot')->with('error', 'Mật khẩu không khớp');
            }
            $user = User::where('email', session('temp_user_data.email'))->first();
            if (!$user) {
                return redirect('/forgot')->with('error', 'Không tìm thấy người dùng');
            }
            $user->password = Hash::make($param['new_password']);
            $user->save();
            session()->forget(['forgot', 'new_password', 'temp_user_data']);
            return redirect('/login')->with('success', 'Đổi mật khẩu thành công. Vui lòng đăng nhập lại');
        }
        return redirect('/forgot')->with('error', 'Hành động không hợp lệ');
    }



    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Đăng xuất thành công');
    }
    public function changePassword(Request $request)
    {

        $userId = session('user_id');
        $user = User::find($userId);
        if ($user->role == User::ROLE_ADMIN) {
            return view('admin.change-password');
        } else if ($user->role == User::ROLE_STAFF) {
            return view('staff.change-password');
        } else if ($user->role == User::ROLE_CLIENT) {
            return view('clients.change-password');
        }
    }
    public function postChangePassword(Request $request)
    {
        $param = $request->all();
        //$user = Auth::user();
        $userId = session('user_id');
        $user = User::find($userId);
        if (!Hash::check($param['current_password'], $user->password)) {
            return redirect('/change_password')->with('error', 'Mật khẩu hiện tại không đúng');
        }
      //  dd($param['new_password']);
        $user->password = Hash::make($param['new_password']);

        $user->save();
        return redirect('/change_password')->with('success', 'Đổi mật khẩu thành công');
    }
}
