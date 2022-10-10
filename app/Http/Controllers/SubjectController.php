<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{

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
            $subject = new Subject();
            $subject->subject = $request->subject;
            $subject->description = $request->description;

            if ($subject->save()>=1) {
                return response()->json(['status'=>'OK','data'=>$subject],201);
            }
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }

    /**
     * Display the specified resource.
     *S
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($paginate = null)
    {
        try {
            if ($paginate === 'paginate') {
                $subject = Subject::select('subjects.id','subjects.subject','subjects.description','subjects.status')
                ->orderBy('id','desc')->paginate(5)->onEachSide(1);
                return $subject;
            }
            else if (!$paginate) {
                $subject = Subject::select('subjects.id','subjects.subject','subjects.description','subjects.status')
                ->orderBy('id','desc')
                ->get();
                return $subject;
            }
            else {
                return response()->json(["message" => "Argument '". $paginate . "' does not exist"],404);
            }
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }

    public function getSubjectsReport()
    {
        try {
            $subject = Subject::select('subjects.id','subjects.subject','subjects.description','subjects.status')
            ->orderBy('id','desc')->paginate(5)->onEachSide(1);
            return $subject;
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
            $subject = Subject::findOrFail($request->id);
            $subject->subject = $request->subject;
            $subject->description = $request->description;
            if ($subject->save()>=1) {
                return response()->json(['status'=>'OK','data'=>$subject],202);
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
