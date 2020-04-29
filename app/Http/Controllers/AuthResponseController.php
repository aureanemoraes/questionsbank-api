<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthResponseController extends Controller
{
    public function sendResponse($response) {
        return response()->json($response, 200);
    }

    public function sendError($error, $code = 400) {
        $response = [
            'error' => $error
        ];

        return response()->json($response, $code);
    }
}
