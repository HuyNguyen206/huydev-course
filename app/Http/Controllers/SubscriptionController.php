<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth');
    }
    public function retrievePlans() {
        $key = \config('services.stripe.secret');
        $stripe = new \Stripe\StripeClient($key);
        $plansraw = $stripe->plans->all(['active' => true]);
        $plans = $plansraw->data;
        foreach($plans as $plan) {
            $prod = $stripe->products->retrieve(
                $plan->product,[]
            );
            $plan->product = $prod;
        }
        return $plans;
    }
    public function showSubscription() {
        $plans = $this->retrievePlans();
        $user = Auth::user();
        return view('frontend.subscribe', [
            'user'=>$user,
            'intent' => $user->createSetupIntent(),
            'plans' => $plans
        ]);
    }
    public function processSubscription(Request $request)
    {
        $request->validate([
            'plan' => 'required'
        ]);
        $user = Auth::user();
        $paymentMethod = $request->input('payment_method');
        $user->createOrGetStripeCustomer();
        $user->addPaymentMethod($paymentMethod);
        $plan = $request->input('plan');
        try {
            $user->newSubscription('default', $plan)->create($paymentMethod, [
                'email' => $user->email
            ]);
        } catch (\Throwable $e) {
            return response()->error('Error creating subscription. ' . $e->getMessage());
        }

        return response()->success(route('subscribed'));
    }

    public function showWelcome(){
        return view('frontend.welcome-subscribe');
    }

    public function updatePlan(Request $request){
        try {
            $user = Auth::user();
            $user->subscription('default')->swap($request->plan);
            return response()->success();
        }
        catch (\Throwable $ex){
            return response()->error($ex->getMessage());
        }
    }

    public function updatePayment(Request $request){
        $request->validate([
            'payment_method' => 'required'
        ]);
        try {
            $user = \auth()->user();
            $user->updateDefaultPaymentMethod($request->payment_method);
            $card_brand = $user->card_brand;
            $card_last_four = $user->card_last_four;
            return response()->success(compact('card_brand', 'card_last_four'));
        }
        catch (\Throwable $ex){
            return  response()->error($ex->getMessage());
        }

    }
}
