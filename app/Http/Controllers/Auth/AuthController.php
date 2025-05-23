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
    // public function login()
    // {
    //     return view('/clients.auth');
    // }

    public function doLogin(Request $request)
    {
        $param = $request->all();
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
                // role = 0 is customers
                return redirect('/admin/concept-category');
            } else if ($role == User::ROLE_STAFF) {
                // role = 1 is staff
                return redirect('/staff/work-schedule');
            } else {
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

        if ($request->input('action') === 'verify') {
            // ✅ Bước xác minh mã
            if ($param['verification_code'] != session('verify_code')) {
                return redirect('/auth')->with('error', 'Mã xác nhận không đúng')->with('singup', true);
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

            return redirect('/auth')->with('success', 'Đăng ký thành công, vui lòng đăng nhập');
        }
        // ✅ Bước đăng ký lần đầu
        if ($param['password'] != $param['re_password']) {
            return redirect('/auth')->with('error', 'Mật khẩu không khớp');
        }

        $checkEmail = User::where('email', $param['email'])->exists();
        if ($checkEmail) {
            return redirect('/auth')->with('error', 'Email đã tồn tại');
        }

        try {
            $verifyCode = rand(100000, 999999);

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
        

            return redirect('/auth')->with('singup', true);
        } catch (\Exception $exception) {
            return redirect('/auth')->with('error', 'Lỗi gửi email xác nhận');
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

    if ($action === 'verify') {
        if ($param['verification_code'] != session('verify_code')) {
            return redirect('/forgot')->with('error', 'Mã xác nhận không đúng');
        }

        session()->forget('verify_code');
        session(['new_password' => true]);

        return redirect('/forgot')->with('success', 'Xác minh thành công. Vui lòng đặt mật khẩu mới');
    }

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

        return redirect('/auth')->with('success', 'Đổi mật khẩu thành công. Vui lòng đăng nhập lại');
    }

    return redirect('/forgot')->with('error', 'Hành động không hợp lệ');
}

  

    public function logout()
    {
        Auth::logout();
        return redirect('/auth');
    }
}
