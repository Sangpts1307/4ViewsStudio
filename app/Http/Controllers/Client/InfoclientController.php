<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;


class InfoclientController extends Controller
{
    public function showForm()
    {
        $userId = session('user_id');
        $user = User::find($userId);
        return view('clients.infoclient', compact('user'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:15',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        $user->update($request->only(['name', 'email', 'phone', 'birth_date', 'address']));

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }
}



