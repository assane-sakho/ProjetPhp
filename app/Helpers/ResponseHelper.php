<?php

namespace App\Helpers;

use Response;

class ResponseHelper
{
    public static function returnResponseSuccess($responseAttr = [])
    {
        $returnData = array(
            'status' => 'success'
        );
        $returnCode = 200;
        $result = array_merge($returnData, $responseAttr);
        return Response::json($result, $returnCode);
    }

    public static function returnResponseError($message = "")
    {
        $returnData = array(
            'status' => 'error',
            'message' => $message
        );
        $returnCode = 500;
        return Response::json($returnData, $returnCode);
    }
}