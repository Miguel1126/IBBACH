<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rate;


class RateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($paginate = null)
    {
        try {
            if ($paginate === 'paginate'){
                $rate = Rate:: 
                select(
                    'rates.id',
                    'rates.price',
                )
                ->orderBy('id','desc')
                ->paginate(5)->onEachSide(1);
                
                return $rate;
            }
            else if (!$paginate){
                $rate = Rate:: 
                select(
                    'rates.id',
                    'rates.price',
                )
                ->orderBy('id','desc')
                ->get();
                return $rate;
            }
            else {
                return response()->json(["message" => "Argument '". $paginate . "' does not exist"],404);
            }
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }
    public function getrates()
    {
        try {
            $rate = Rate:: 
            select(
                'rates.id',
                'rates.price',
            )
            ->orderBy('id','desc')
            ->paginate(5)->onEachSide(1);
            return $rate;
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $rate = Rate:: findOrFail($request->id);
            $rate->price = $request->price;
            if ($rate->save()>=1) {
                return response()->json(['status'=>'OK','data'=>$rate],202);
            }
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
