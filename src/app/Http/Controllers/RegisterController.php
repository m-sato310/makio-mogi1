<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        $user->sendEmailVerificationNotification();

        if ($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()) {
            return redirect('/verify-email');
        }

        return redirect('/register/profile');
    }

    public function showVerifyEmail()
    {
        return view('auth.verify-email');
    }

    public function checkVerification()
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return redirect('/register/profile');
        }

        return back()->with('status', 'メール認証が完了していません');
    }

    public function sendVerificationEmail()
    {
        $user =Auth::user();

        if ($user->hasVerifiedEmail()) {
            return redirect('/?tab=mylist');
        }

        $user->sendEmailVerificationNotification();

        return back()->with('status', '認証メールを再送しました');
    }

    public function verifyEmail(Request $request)
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return redirect('/?tab=mylist');
        }

        if ($user->id == $request->route('id')) {
            $user->markEmailAsVerified();
            event(new Verified($user));
        }

        return redirect('/register/profile');
    }

    public function createProfile()
    {
        $user = Auth::user();

        if ($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()) {
            return redirect('/verify-email')->with('status', 'メール認証が完了していません');
        }

        return view('mypage.profile', compact('user'))->with('mode', 'setup');
    }

    public function storeProfile(AddressRequest $request)
    {

        $user = Auth::user();

        $profileRequest = app(ProfileRequest::class);
        $profileRequest->validateResolved();

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/profile', $filename);

            $user->profile_image = $filename;
        }

        $user->name = $request->input('name');
        $user->zipcode = $request->input('zipcode');
        $user->address = $request->input('address');
        $user->building = $request->input('building');

        $user->save();

        return redirect('/?tab=mylist');
    }
}
