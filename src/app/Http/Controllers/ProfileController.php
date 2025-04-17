<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('mypage.profile');
    }

    public function update(AddressRequest $request)
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

        return redirect('/mypage?tab=buy');
    }
}
