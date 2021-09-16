<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class LocationController extends Controller
{
    public function index()
    {
        return view('locations');
    }
}
