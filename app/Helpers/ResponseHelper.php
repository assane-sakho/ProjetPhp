<?php

namespace App\Helpers;

use Response;

class ResponseHelper
{
    /**
     * Return a json response with code 200
     * @var responseAttr
     */
    public static function returnResponseSuccess($responseAttr = [])
    {
        $returnData = array(
            'status' => 'success'
        );
        $returnCode = 200;
        $result = array_merge($returnData, $responseAttr);
        return Response::json($result, $returnCode);
    }

    /**
     * Return a json error with a message
     * @var responseAttr
     */
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
