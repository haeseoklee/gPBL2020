<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Employee;

class GoogleMapController extends Controller
{
    //
    public function index()
    {
        return view('distance', []);
    }

    public function address()
    {
        $address = file_get_contents(base_path('resources/json/distance.json'));
        print_r($address);
        // $address = json_encode($address, true);
        // response()->json($address);
    }
}

