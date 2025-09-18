<?php

namespace App\Traits;

trait ApiResponses
{



    protected function success(string $message, $data=[],int $statusCode = 200){
        if(empty($data)){
             return response()->json([
            "success"=> true,
            "message"=> $message,
            ], $statusCode);
        }

        return response()->json([
            "success"=> true,
            "message"=> $message,
            "data"=>$data,
            ], $statusCode);

    }

     protected function error(string $message, int $statusCode ){
        return response()->json([
            "success"=> false,
            "message"=> $message
            ], $statusCode);

    }
}
