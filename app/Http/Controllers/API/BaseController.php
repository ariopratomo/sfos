<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    // send success response
    public function sendResponse($result = [], $message, $code = 200)
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];
        if(!empty($result)){
            $response['data'] = $result;
        }
        return response()->json($response, 200);
    }

    // send error response
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }


}
