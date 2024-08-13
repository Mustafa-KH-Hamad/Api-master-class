<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function includes(string $relationships) :bool {
        
        $param = request('includes');
        if(!isset($param)){
            return false ; 
        }
        $array = explode(',',strtolower($param));
        return in_array(strtolower($relationships),$array) ; 
    }
}
