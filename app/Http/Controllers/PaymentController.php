<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function payment()
    {
        $availablePlans =[
            'price_1IkRFRLZUh8627nbly70s6t3' => "Daily",
            'price_1IkQeuLZUh8627nbK92ARUjH' => "Monthly",
            'price_1IkQeuLZUh8627nbRDCbkn9w' => "Yearly",
        ];
        $data = [
            'intent' => auth()->user()->createSetupIntent(),
            'plans'=> $availablePlans
        ];
        return view('payment')->with($data);
    }

    public function subscribe(Request $request)
    {
        $user = auth()->user();
        $paymentMethod = $request->payment_method;

        $user->newSubscription('primary', $request->plan)->create($paymentMethod);

        return response([
            'success_url'=> redirect()->intended('/')->getTargetUrl(),
            'message'=>'success'
        ]);

    }

    public function unsubscribe(Request $request)
    {
        auth()->user()->subscription('primary')->cancel();
        return back()->with("success", "Unsubscribe success!!");
    }

}
