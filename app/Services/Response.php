<?php

namespace App\Services;

class Response
{
    const SUCCESS = true;
    const FAIL = false;

    public static function notFoundError($message = 'Not Found', $statusCode = 404)
    {
        return response()->json([
            'success' => self::FAIL,
            'message' => $message
        ], $statusCode)->header("Access-Control-Allow-Origin",  "*");
    }

    public static function badRequestError($message = 'Bad Request', $data = null, $statusCode = 400)
    {
        $response['success'] = self::FAIL;
        $response['message'] = $message;
        if ($data) {
            $response['error'] = $data;
        }
        return response()->json($response, $statusCode)->header("Access-Control-Allow-Origin",  "*");
    }

    public static function unauthorizedError($message = 'Unauthorized', $statusCode = 401)
    {
        return response()->json([
            'success' => self::FAIL,
            'message' => $message
        ], $statusCode)->header("Access-Control-Allow-Origin",  "*");
    }

    public static function conflictError($message = 'Data already exist', $statusCode = 409)
    {
        return response()->json([
            'success' => self::FAIL,
            'message' => $message
        ], $statusCode)->header("Access-Control-Allow-Origin",  "*");
    }

    public static function internalServerError($message = 'Internal Server Error', $error, $statusCode = 500)
    {
        return response()->json([
            'success' => self::FAIL,
            'message' => $message,
            'error' => $error
        ], $statusCode)->header("Access-Control-Allow-Origin",  "*");
    }

    public static function success($message = 'Request Success', $data = null, $statusCode = 200)
    {
        $response['success'] = self::SUCCESS;
        $response['message'] = $message;
        if (!is_null($data)) {
            $response['data'] = $data;
        }
        return response()->json($response, $statusCode)->header("Access-Control-Allow-Origin",  "*");
    }
}
