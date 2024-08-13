<?php

namespace App\Trait;



trait APIResponses{

    protected function ok ($data=[],$message){
        return $this->success($data,$message,200);
    }

    protected function success( $data=[],$message , $status = 200){
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => $status
        ],$status);
    }
    protected function error( $message , $status = 401){
        return response()->json([
            'message' => $message,
            'status' => $status
        ],$status);
    }
}