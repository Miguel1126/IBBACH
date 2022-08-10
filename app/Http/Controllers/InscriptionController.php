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
        $userRole = auth()->user()->role;
        if ($userRole === 'docente') {
            try {
                $inscription = new Inscription();
                $inscription->registration_date = $request->registration_date;
                $inscription->status = $request->status;
                $inscription-> user_id = $request-> user_id;
                $inscription-> load_id = $request-> load_id;
                if ($inscription->save()>=1) {
                    return response()->json(['status'=>'OK','data'=>$inscription],201);
                }
            }
            catch (\Exception $e) {
                return response()->json(["message" => $e->getMessage()],500);
            }   
        }
	    else {
            return response()->json(['message' => 'No tienes autorización para ejecutar esta acción, inicia sesión en una cuenta válida'],401);
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
        $userRole = auth()->user()->role;
        if ($userRole === 'docente') {
            try {
                $inscriptions = Inscription::join('users', 'inscriptions.user_id', '=', 'users.id')
                ->join('loads', 'inscriptions.load_id', '=', 'loads.id')
                ->join('subjects', 'loads.subject_id', 'subjects.id')
                ->select(
                    'inscriptions.id',
                    'inscriptions.registration_date',
                    'inscriptions.status',
                    'users.name',
                    'users.last_name',
                    'users.code',
                    'subjects.subject',
                    'subjects.description'
                )
                ->where('inscriptions.status', '=', 'inscrito')
                ->orderBy('id', 'asc')
                ->get();
                return $inscriptions;
            }
            catch (\Exception $e) {
                return response()->json(["message" => $e->getMessage()],500);
            }   
        }
	    else {
            return response()->json(['message' => 'No tienes autorización para ejecutar esta acción, inicia sesión en una cuenta válida'],401);
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
