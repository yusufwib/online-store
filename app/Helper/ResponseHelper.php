<?php

namespace App\Helper;

use DB;

class ResponseHelper
{

    public function responseGet ($success, $code, $data, $msg) {
        return response()->json([
            'status_code' => $code,
            'message' => isset($msg) ? $msg : ($success ? 'Success get data' : 'Failed get data'),
            'success' => $success,
            'data' => $data
        ], $code);
    }

    public function responsePost ($success, $code = 201, $msg) {
        return response()->json([
            'status_code' => $code,
            'message' => isset($msg) ? $msg : ($success ? 'Success post data' : 'Failed post data'),
            'success' => $success
        ], $code);
    }

    public function responseUpdate ($success, $code, $msg) {
        return response()->json([
            'status_code' => $code,
            'message' => isset($msg) ? $msg : ($success ? 'Success update data' : 'Failed update data'),
            'success' => $success
        ], $code);
    }

    public function responseDelete ($success, $code, $msg) {
        return response()->json([
            'status_code' => $code,
            'message' => isset($msg) ? $msg : ($success ? 'Success delete data' : 'Failed delete data'),
            'success' => $success
        ], $code);
    }

    function generateRandomString ($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
