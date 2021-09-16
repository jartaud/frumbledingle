<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

class CategoryController extends Controller
{
    use ValidatesRequests;

    public function index()
    {
        $categories = Category::select('id', 'parent_id', 'name')
            ->with('parent:id,name');

        return response()->json($categories->paginate(10));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|between:3,255',
            'parent_id' => 'nullable|numeric',
        ]);

        $category = Category::create([
            'name'        => $request->name,
            'parent_id'   => $request->parent_id,
        ]);

        return response($category, 201);
    }

    public function destroy(Category $category)
    {
        $category->delete();
    }
}
