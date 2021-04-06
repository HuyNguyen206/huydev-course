<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class ProfileController extends Controller
{
    //

    public function getProfile(User $user){
        $seriesBeingWatch = $user->getSeriesBeingWatch();
        $stripe = new StripeClient(config('services.stripe.secret'));
        $planId = optional($user->subscriptions->first())->stripe_plan;
        if($planId){
            $subscriptionPlan = $stripe->plans->retrieve($planId);
            $subscriptionPlan->product = $stripe->products->retrieve($subscriptionPlan->product);
            $plansraw = $stripe->plans->all(['active' => true]);
            $plans = $plansraw->data;
            foreach($plans as $plan) {
                $prod = $stripe->products->retrieve(
                    $plan->product,[]
                );
                $plan->product = $prod;
            }
        }else{
            $subscriptionPlan = null;
            $plans = [];
        }
        return view('frontend.user.profile', compact('user', 'seriesBeingWatch', 'subscriptionPlan', 'plans'));
    }
}
