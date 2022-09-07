<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;


class PaymentController extends Controller
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
            $payment = new Payment();
            $payment->payment_date = $request->payment_date;
            $payment->last_pay_date = $request->last_pay_date;
            $payment->status = $request->status;
            $payment->sourcharge = $request->sourcharge;
            $payment->rate_id = $request->rate_id;
            $payment->user_id = $request->user_id;
            if ($payment->save()>=1) {
                return response()->json(['status'=>'OK','data'=>$payment],201);
            }
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
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
            $rates = Payment::join('users', 'payments.user_id', '=', 'users.id')
            ->join('rates', 'payments.rate_id', '=', 'rates.id')
            ->select(
                'payments.id',
                'payments.payment_date',
                'payments.last_pay_date',
                'payments.status',
                'payments.sourcharge',
                'users.name as student',
                'rates.price'
            )
            ->orderBy('id', 'asc')
            ->get();
            return $rates;
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }

    public function getPaymentsP()
    {
        try {
            $rates = Payment::join('users', 'payments.user_id', '=', 'users.id')
            ->join('rates', 'payments.rate_id', '=', 'rates.id')
            ->select(
                'payments.id',
                'payments.payment_date',
                'payments.last_pay_date',
                'payments.status',
                'payments.sourcharge',
                'users.name as student',
                'users.last_name',
                'users.code',
                'rates.price'
            )
            //->where('payments.status', '=', 'pendiente')
            ->orderBy('id', 'asc')
            ->get();
            return $rates;
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }
    public function getPaymentsS()
    {
        try {
            $rates = Payment::join('users', 'payments.user_id', '=', 'users.id')
            ->join('rates', 'payments.rate_id', '=', 'rates.id')
            ->select(
                'payments.id',
                'payments.payment_date',
                'payments.last_pay_date',
                'payments.status',
                'payments.sourcharge',
                'users.name as student',
                'users.last_name',
                'users.code',
                'rates.price'
            )
            //->where('payments.status', '=', 'solvente')
            ->orderBy('id', 'asc')
            ->get();
            return $rates;
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
