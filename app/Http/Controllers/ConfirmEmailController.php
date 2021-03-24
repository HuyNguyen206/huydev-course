<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ConfirmEmailController extends Controller
{
    //
    public function confirmEmail(Request $request){

        $user = User::whereConfirmToken($request->token)->first();
        if($user){
            $user->confirm();
            session()->flash('success', 'Your email has been confirmed.');
            return redirect('/');
        }
        else{
            session()->flash('fail', "Your email hasn't been confirmed.");
            return redirect('/wrong-token');
        }

    }

}
