<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\ShippingAddressRequest;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session;
use Stripe\Stripe;

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

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/'),
            'cancel_url' => url('/'),
            ]);

        return redirect($session->url);
    }

    public function editShippingAddress(Item $item)
    {
        $user = auth()->user();

        return view('purchase.address', compact('item', 'user'));
    }

    public function storeShippingAddress(ShippingAddressRequest $request, Item $item)
    {
        session([
            'custom_address' => [
                'zipcode' => $request->zipcode,
                'address' => $request->address,
                'building' => $request->building,
            ]
            ]);

            return redirect("/purchase/{$item->id}");
    }

}
