<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
            DB::beginTransaction();
            $errors = 0;

            $payment = new Payment();
            $payment->payment_date = $request->payment_date;
            $payment->total = $request->total;
            $payment->sourcharge = $request->sourcharge;
            $payment->status = "S";
            $payment->paid_count = $request->paidMonths;
            $payment->pay_price = $request->pay_price;
            $payment->rate_id = $request->rate_id;
            $payment->user_id = $request->user_id;
            if ($payment->save() <= 0) {
                $errors++;
            }
            
            $user = User::findOrFail($request->user_id);
            $user->paid_months += $request->paidMonths;
            if ($user->save() <= 0) {
                $errors++;
            }

            if ($errors > 0) {
                DB::rollBack();
            }

            if ($errors === 0) {
                DB::commit();
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
                'payments.total',
                'payments.status',
                'payments.sourcharge',
                'users.name as student',
                'rates.price'
            )
            ->orderBy('id', 'desc')
            ->paginate(5)->onEachSide(1);
            return $rates;
        }
        catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()],500);
        }
    }

    public function getUserPayments($userId) {
        try {
            $rates = Payment::join('users', 'payments.user_id', '=', 'users.id')
            ->join('rates', 'payments.rate_id', '=', 'rates.id')
            ->select(
                'payments.id',
                'payments.payment_date',
                'payments.paid_count',
                'payments.total',
                'payments.pay_price',
                'payments.status',
                'payments.sourcharge',
                DB::raw("CONCAT(users.name,' ',users.last_name) AS student"),
                'rates.price'
            )
            ->where('users.id','=',$userId)
            ->orderBy('id', 'desc')
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
                'payments.paid_count',
                'payments.total',
                'payments.status',
                'payments.sourcharge',
                DB::raw("CONCAT(users.name,' ',users.last_name) AS student"),
                'rates.price'
            )
            ->where('payments.status', '=', 'S')
            ->orderBy('id', 'desc')
            ->paginate(5)->onEachSide(1);
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
    public function update(Request $request)
    {
        try {
            $payment = Payment::findOrFail($request->id);
            $payment->payment_date = $request->payment_date;
            $payment->last_pay_date = $request->last_pay_date;
            $payment->status = $request->status;
            $payment->sourcharge = $request->sourcharge;
            $payment->rate_id = $request->rate_id;
            $payment->user_id = $request->user_id;
            if ($payment->save()>=1) {
                return response()->json(['status'=>'OK','data'=>$payment],202);
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
