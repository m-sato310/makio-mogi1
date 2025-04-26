<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $tab = $request->query('tab', 'sell');

        if ($tab === 'buy') {
            $items = $user->purchases()->with('item')->latest()->get()->pluck('item');
        } else {
            $items = $user->items()->latest()->get();
        }

        return view('mypage.index', compact('user', 'items', 'tab'));
    }

    public function editProfile()
    {
        $user = auth()->user();
        return view('mypage.profile', compact('user'))->with('mode', 'edit');
    }

    public function updateProfile(AddressRequest $request, ProfileRequest $profileRequest)
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

        return redirect('/mypage');
    }
}
