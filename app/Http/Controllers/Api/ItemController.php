<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use App\Http\Requests\ItemRequest;
use App\Models\Category;
use Illuminate\Routing\Controller;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::select('id', 'category_id', 'location_id', 'name', 'price')
            ->with('category:id,name')
            ->filter(request()->only('location'))
            ->paginate(10);

        return response()->json($items);
    }

    public function store(ItemRequest $request)
    {
        $parent = Category::find($request->category_id);

        Item::create([
            'name'          => $request->input('name'),
            'category_id'   => $request->input('category_id'),
            'location_id'   => $request->input('location_id'),
            'price'         => $request->input('price'),
            'parent_category_id' => $parent ? $parent->parent_id : null
        ]);

        return response('', 201);
    }

    public function destroy(Item $item)
    {
        $item->delete();
    }
}
