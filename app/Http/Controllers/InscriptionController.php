<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscription;

class InscriptionController extends Controller
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
        try {
            $inscription = new Inscription();
            $inscription->registration_date = $request->registration_date;
            $inscription->status = $request->status;
            $inscription-> user_id = $request-> user_id;
            $inscription-> subject_id = $request-> subject_id;
            if ($inscription->save()>=1) {
                return response()->json(['status'=>'OK','data'=>$inscription],201);
            }
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        try {
            $inscriptions = Inscription::join('users', 'inscriptions.user_id', '=', 'users.id')
            ->join('subjects', 'inscriptions.subject_id', '=', 'subjects.id')
            ->select(
                'inscriptions.id',
                'inscriptions.registration_date as date',
                'inscriptions.status',
                'users.name as student',
                'subjects.subject',
            )
            ->orderBy('id', 'asc')
            ->get();
            return $inscriptions;
        }
        catch (\Exception $e) {
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
