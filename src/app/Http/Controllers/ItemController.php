<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab');
        $keyword = $request->query('keyword');

        if ($tab === 'mylist') {
            if (Auth::check()) {
                $items = Auth::user()->likedItems()->when($keyword, function ($query) use ($keyword) {
                    return $query->where('name', 'like', '%' . $keyword . '%');
                })
                ->get();
            } else {
                $items = collect();
            }
        } else {
            $items = Item::when(Auth::check(), function ($query) {
                return $query->where('user_id', '!=', Auth::id());
            })
            ->when($keyword, function ($query) use ($keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->get();
        }

        return view('items.index', compact('items', 'tab', 'keyword'));
    }
}
