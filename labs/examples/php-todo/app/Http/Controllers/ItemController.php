<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(Request $req)
    {
        $user = Auth::user();
        $items = $user->items;

        if (empty($items)) {
            $items = [];
        };

        // Apply search filter if URL passed
        if ($req->has('search')) {
            $s = Str::lower($req->get('search', ''));
            $items = $items->filter(function ($item) use ($s) {
                return Str::contains(Str::lower($item->name), $s) || Str::contains(Str::lower($item->content), $s);
            });
        }

        return view('item_list')->with('items', $items);
    }

    public function create(): View
    {
        return view('item_create');
    }

    public function empty()
    {
        $user = Auth::user();
        $items = Item::onlyTrashed()->where('user_id', $user->id)->forceDelete();

        return redirect('/trash');
    }

    public function edit($id): View
    {
        $item = Item::find($id);

        if (empty($item)) {
            return abort(404);
        }

        return view('item_edit', compact('item'));
    }

    public function store(Request $req)
    {
        $validated = $req->validate([
            'name' => 'required|max:255',
            'content' => 'required',
        ]);

        $user = Auth::user();
        $user_id = $user->id;

        $item = new Item;
        $item->name = $req->name;
        $item->user_id = $user_id;
        $item->content = $req->content;
        $item->save();
        return redirect('/item');
    }

    public function read($id)
    {
        $item = Item::withTrashed()->find($id);

        if (empty($item)) {
            return abort(404);
        }

        return view('item_show', compact('item'));
    }

    public function update(Request $req, $id)
    {
        $validated = $req->validate([
            'name' => 'required|max:255',
            'content' => 'required',
        ]);

        $item = Item::find($id);

        $item->name = $req->name;
        $item->content = $req->content;
        $item->save();
        return redirect('/item');
    }

    public function delete($id)
    {
        $item = Item::find($id);

        if (empty($item)) {
            return abort(404);
        }

        $item->delete();
        return redirect('/item');
    }

    public function restore($id)
    {
        $item = Item::withTrashed()->find($id);

        if (empty($item)) {
            return abort(404);
        }

        $item->restore();

        return redirect('/trash');
    }

    public function trash(Request $req)
    {
        $user = Auth::user();
        $items = Item::onlyTrashed()->where('user_id', $user->id)->get();

        return view('item_list')->with('items', $items);
    }
}
