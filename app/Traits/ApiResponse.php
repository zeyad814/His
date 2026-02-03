<?php

namespace App\Traits;

trait ApiResponse{

        public static function successResponse($message = "",$status_code = 200,$data = []){
            $body = [
                'success' => true,
                'data' => $data,
                'message' => $message,
            ];
            return response()->json($body,$status_code);
        }

        public static function errorResponse($message = "",$status_code = 400,$data = []){
            $body = [
                'success' => false,
                'data' => $data,
                'message' => $message,
            ];
            return response()->json($body,$status_code);
        }
}
