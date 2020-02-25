<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\Assign;
use App\Models\Employee;

class APIController extends Controller
{
    //
    public function index()
    {
        $leaves = DB::table('leaves')
            ->join('averwt', 'averwt.employee_number', '=', 'leaves.employee_number')
            ->orderBy('leaves.employee_number', 'asc')
            ->distinct()
            ->get();

        $leaves_json = $leaves->toJson(JSON_UNESCAPED_UNICODE);
        
        return response()->json($leaves_json);
    }
 
    public function filter(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $leaves = DB::table('leaves')
            ->join('averwt', 'averwt.employee_number', '=', 'leaves.employee_number')
            ->distinct()
            ->orderBy('leaves.employee_number', 'asc');
        
        if (isset($data['gender']) && $data['gender'] != '')
        {
            $leaves = $leaves->where('gender', 'like', $data['gender']);
        }
        if (isset($data['marital']) && $data['marital'] != '')
        {
            $leaves = $leaves->where('marital_status', 'like', '%'.$data['marital'].'%');
        }
        
        $leaves_json = $leaves->get()->toJson(JSON_UNESCAPED_UNICODE);
        
        return response()->json($leaves_json);
    
    }

}

