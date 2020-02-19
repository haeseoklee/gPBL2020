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
        $leaves = Leave::all();
        $leaves_json = $leaves->toJson(JSON_UNESCAPED_UNICODE);
        
        return response()->json($leaves_json);
    }
 
    public function consoleTest($data){
        echo "<script>console.log('consoletest : ". $data. "');</script>";
    }   
    public function filter(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        
        $gender = $data['gender']; 
        
        if ($gender != '')
        {
            $leaves = Leave::where('gender', 'like', $gender)->get();
        }
        else 
        {
            $leaves = Leave::all();
        }

        $leaves_json = $leaves->toJson(JSON_UNESCAPED_UNICODE);
        
        return response()->json($leaves_json);
    
    }

}

