<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assign;

class AssignController extends Controller
{
    //
    public function index()
    {
        $assigns = Assign::all();
        return view('assign', ['assigns' => $assigns]);
    }
}

