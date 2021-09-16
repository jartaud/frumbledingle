<?php

namespace App\Http\Controllers\Api;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

class LocationController extends Controller
{
    use ValidatesRequests;
    
    public function index()
    {
        return response()->json(Location::paginate(10));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|between:3,255|unique:locations'
        ]);

        Location::create(['name' => $request->input('name')]);

        return response('', 201);
    }

    public function destroy(Location $location)
    {
        $location->delete();
    }
}
