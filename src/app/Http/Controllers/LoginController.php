<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function store(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'ログイン情報が登録されていません'])->withInput();
        }

        if (is_null(Auth::user()->email_verified_at)) {
            Auth::logout();
            return back()->withErrors(['email' => 'メールアドレスの認証が完了していません'])->withInput();
        }

        return redirect('/?tab=mylist');
    }
}
