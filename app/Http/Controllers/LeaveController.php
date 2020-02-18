<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;

class LeaveController extends Controller
{
    //
    public function index()
    {
        $leaves = Leave::all();
        $male_num = Leave::where('gender', 'Male')->count();
        
        $female_num = Leave::where('gender', 'Female')->count();

        return view('leave', ['leaves' => $leaves, 'male_num' => $male_num, 'female_num' => $female_num ]);
    }
}

