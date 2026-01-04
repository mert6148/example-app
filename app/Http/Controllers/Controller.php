<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

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

    public function sendSuccess($message)
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    public function sendSuccessData($data, $message)
    {
        $response = [
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }
}

class Response
{
    public $success;
    public $data;
    public $message;

    public function __construct($success, $data, $message)
    {
        $this->success = $success;
        $this->data = $data;
        $this->message = $message;
    }

    public function toJson()
    {
        return response()->json([
            'success' => $this->success,
            'data' => $this->data,
            'message' => $this->message,
        ], 200);
    }

    public function toErrorJson($code = 404)
    {
        return response()->json([
            'success' => $this->success,
            'message' => $this->message,
        ], $code);
    }

    public function toSuccessJson()
    {
        return response()->json([
            'success' => $this->success,
            'message' => $this->message,
        ], 200);
    }
}

class ResponseData
{
    public $success;
    public $data;
    public $message;

    public function __construct($success, $data, $message)
    {
        $this->success = $success;
        $this->data = $data;
        $this->message = $message;
    }

    public function toJson()
    {
        return response()->json([
            'success' => $this->success,
            'data' => $this->data,
            'message' => $this->message,
        ], 200);
    }

    public function toErrorJson($code = 404)
    {
        return response()->json([
            'success' => $this->success,
            'message' => $this->message,
        ], $code);
    }

    public function toSuccessJson()
    {
        return response()->json([
            'success' => $this->success,
            'message' => $this->message,
        ], 200);
    }
}

class ResponseError
{
    public $success;
    public $message;

    public function __construct($success, $message)
    {
        $this->success = $success;
        $this->message = $message;
    }

    public function toErrorJson($code = 404)
    {
        return response()->json([
            'success' => $this->success,
            'message' => $this->message,
        ], $code);
    }
}

