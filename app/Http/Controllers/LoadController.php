<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Load;

class LoadController extends Controller
{
    public function index()
    {
        
    }
    //agregar cargas
    public function store(Request $request)
    {
        try{
            $load = new Load();
            $load->status = $request->status;
            $load->user_id = $request->user_id;
            $load->cycle_id = $request->cycle_id;
            $load->subject_id = $request->subject_id;
            if($load->save()>=1){
                return response()->json(['status'=>'ok','data'=>$load],201);
            }
            $load->save();
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    //mostrar cargas
    public function show()
    {
        try {
            $load = Load::orderBy('id','asc')->get();
            return $load;
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }


}
