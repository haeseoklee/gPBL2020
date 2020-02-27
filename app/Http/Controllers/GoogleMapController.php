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
}

