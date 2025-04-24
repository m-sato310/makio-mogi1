<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function create(Item $item)
    {
        $user = Auth::user();

        $address = session('custom_address') ?? [
            'zipcode' => $user->zipcode,
            'address' => $user->address,
            'building' => $user->building,
        ];

        return view('purchase.purchase', compact('item', 'address'));
    }

    public function store(PurchaseRequest $request, Item $item)
    {
        Auth::user()->purchases()->create([
            'item_id' => $item->id,
            'payment_method' => $request->payment_method,
            'zipcode' => $request->zipcode,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        $request->session()->forget('custom_address');

        return redirect('/');
    }
}
