<?php

namespace App\Exceptions;

use Exception;

class AuthFailException extends Exception
{
    //
    public function render(){
        return response()->json([
            'message' => trans('auth.failed')
        ], 422);
    }
}
