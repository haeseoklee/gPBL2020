<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\Assign;
use App\Models\Employee;

class APIController extends Controller
{
    //
    public function index()
    {
        $leaves = Leave::orderBy('employee_number', 'asc')->get();

        $leaves_json = $leaves->toJson(JSON_UNESCAPED_UNICODE);
        
        return response()->json($leaves_json);
    }
 
    public function filter(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        // TODO: cross join WT table and leaves table and 
        $leaves = Leave::orderBy('employee_number', 'asc');
        
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

