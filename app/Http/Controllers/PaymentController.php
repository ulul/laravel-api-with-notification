<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use App\Notifications\PaymentNotification;
use Exception;
use Notification;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::orderBy('id', 'desc')->paginate(5);
        return response()->json($payments, 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentRequest $request)
    {
        try{
            $payment = Payment::create([
                'name' => $request->name,
                'email' => $request->email
            ]);

            return response()->json([
                'status_code' => 200,
                'message' => 'Payment has been successfully created',
                'data' => $payment
            ]);
        }catch(Exception $e){
            return response()->json([
                'status_code' => $e->getCode(),
                'data' => $e->getMessage()
            ], $e->getCode());
        }
    }

    /**
     * Activate specified payment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate($id)
    {
        try {
            $payment = Payment::where('id', $id)->first();
            
            if (! $payment){
                throw new \Exception('Payment not found', 404);
            }

            $payment->is_active = true;
            $payment->save();

            Notification::send($payment, new PaymentNotification($payment->is_active));

            return response()->json([
                'status_code' => 200,
                'message' => 'Payment has been successfully activated',
                'data' => $payment
            ]);

        }catch(Exception $e){
            return response()->json([
                'status_code' => $e->getCode(),
                'data' => $e->getMessage()
            ], $e->getCode());
        }
    }

    /**
     * Activate specified payment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivate($id)
    {
        try {
            $payment = Payment::where('id', $id)->first();

            if (!$payment) {
                throw new \Exception('Payment not found', 404);
            }

            $payment->is_active = false;
            $payment->save();

            Notification::send($payment, new PaymentNotification($payment->is_active));

            return response()->json([
                'status_code' => 200,
                'message' => 'Payment has been successfully deactivated',
                'data' => $payment
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => $e->getCode(),
                'data' => $e->getMessage()
            ], $e->getCode());
        }
    }
   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentRequest $request, $id)
    {
        try {
            $payment = Payment::find($id);

            if (!$payment) {
                throw new Exception('Data payment not found', 404);
            }

            $payment->update([
                'name' => $request->name,
                'email' => $request->email
            ]);

            return response()->json([
                'status_code' => 200,
                'message' => 'Payment has been successfully updated',
                'data' => $payment
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => $e->getCode(),
                'data' => $e->getMessage()
            ], $e->getCode());
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
        try{
            $payment = Payment::find($id);

            if (! $payment){
                throw new Exception('Data payment not found', 404);
            }

            $payment->delete();
            return response()->json([
                'status_code' => 200,
                'message' => 'Payment has been successfully deleted'
            ]);
        }catch(Exception $e){
            return response()->json([
                'status_code' => $e->getCode(),
                'data' => $e->getMessage()
            ], $e->getCode());
        }
    }
}
