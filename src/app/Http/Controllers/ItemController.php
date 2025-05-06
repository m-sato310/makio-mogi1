<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
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
                $items = Auth::user()->likedItems()
                ->where('items.user_id', '!=', Auth::id())
                ->when($keyword, function ($query) use ($keyword) {
                    return $query->where('name', 'like', '%' . $keyword . '%');
                })
                ->get();
            } else {
                $items = collect();
            }
        } else {
            $items = Item::when(Auth::check(), function ($query) {
                return $query
                ->where('user_id', '!=', Auth::id());
            })
            ->when($keyword, function ($query) use ($keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->get();
        }

        return view('items.index', compact('items', 'tab', 'keyword'));
    }

    public function show(Item $item)
    {
        $isPurchased = $item->purchase()->exists();

        $comments = $item->comments()->with('user')->latest()->get();

        $liked = auth()->check() ? $item->likes()->where('user_id', auth()->id())->exists() : false;

        return view('items.show', compact('item', 'comments', 'isPurchased', 'liked'));
    }

    public function comment(CommentRequest $request, Item $item)
    {
        $item->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->validated()['content'],
        ]);

        return redirect()->back();
    }

    public function like(Item $item)
    {
        if (!$item->likes()->where('user_id', auth()->id())->exists()) {
            $item->likes()->attach(auth()->id());
        }

        return back();
    }

    public function unlike(Item $item)
    {
        if ($item->likes()->where('user_id', auth()->id())->exists()) {
            $item->likes()->detach(auth()->id());
        }

        return back();
    }

    public function showItemExhibitionForm()
    {
        $categories = Category::all();

        return view('sell.sell', compact('categories'));
    }

    public function storeExhibition(ExhibitionRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image_path')) {
            $filename = $request->file('image_path')->hashName();
            $request->file('image_path')->storeAs('items', $filename, 'public');
            $validated['image_path'] = $filename;
        }

        $validated['user_id'] = Auth::id();
        $item = Item::create($validated);

        if (isset($validated['categories'])) {
            $item->categories()->sync($validated['categories']);
        }

        return redirect('/mypage');
    }
}
