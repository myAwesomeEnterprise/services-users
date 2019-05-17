<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class CheckTokenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function check()
    {
        return response([
            "message" => "Valid token.",
        ], 200);
    }
}
