<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cycle;

class CycleController extends Controller
{
  
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        try{
            $cycle = new Cycle();
            $cycle->cycle = $request-> cycle;
            $cycle->start_date = $request-> start_date;
            $cycle->end_date = $request-> end_date;
            $cycle->status = $request-> status;
            $cycle->group_id = $request-> group_id;
            if($cycle->save()>=1){
                return response()->json(['status'=>'ok','data'=>$cycle],201);
            }
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    public function show($id)
    {
        //
    }

}
