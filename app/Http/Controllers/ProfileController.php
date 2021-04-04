<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //

    public function getProfile(User $user){
        $seriesBeingWatch = $user->getSeriesBeingWatch();
        return view('frontend.user.profile', compact('user', 'seriesBeingWatch'));
    }
}
