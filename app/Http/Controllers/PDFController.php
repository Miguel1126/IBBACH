<?php

namespace App\Http\Controllers;

use App\Models\Cycle;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    
    public function cyclesPDF( Request $request ){
        $date1 = $request->date1;
        $date2 = $request->date2;
        $cycles = Cycle::join('groups', 'cycles.group_id', '=', 'groups.id')
        ->select('cycles.id','cycles.cycle',
        'cycles.start_date',
        'cycles.end_date',
        'cycles.status',
        'groups.group')
        ->whereBetween('start_date',[$date1,$date2])
        ->orderBy('cycles.id','desc')->get();
        $pdf = \PDF::loadView("cyclesPDF", compact('cycles'));
        return $pdf->download('cycles.pdf');

    }
}
