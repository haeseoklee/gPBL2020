<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    //
    public function index()
    {
        $employees = Employee::get();
        return view('employee', ['employees' => $employees]);
    }

    public function averwt()
    {
        return view('averwt', []);
    }

    public function about()
    {
        return view('about', []);
    }

    public function leaveAverwt()
    {
        return view('leaveAverwt', []);
    }
}

