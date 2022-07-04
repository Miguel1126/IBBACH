<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
class NoteController extends Controller
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
        try{
            $note = new Note();
            $note-> ev1 = $request->ev1;
            $note-> ev2 = $request->ev2;
            $note-> ev3 = $request->ev3;
            $note-> ev4 = $request->ev4;
            $note-> ev5 = $request->ev5;
            $note-> percentege = $request->percentege;
            $note-> finalAverage = $request->finalAverage;
            $note-> status = $request->status;
            $note-> load_id = $request->load_id;
            $note-> insription_id = $request->inscription_id;
            if($note->save()>=1){
                return response()->json(['status'=>'ok','data'=>$note],201);
            }
        }
        catch(\Exception $e){
            return $e->getMessage();
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $note = Note::orderBy('id','asc')->get();
            return $note;
        }
        catch (\Exception $e){
            return $e->getMessage();
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
    public function update(Request $request, $id)
    {
        //
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

