<?php

namespace App\Common\Base;

// use App\Exceptions\APIException;
use Illuminate\Support\Facades\{Validator};
use Schema;
use Illuminate\Routing\Controller;
use App\Models\User;

class BaseController extends Controller
{

    protected function _response($data , $meta = null){

        
        if(!is_null($meta)){
            return response()->json( [
                'data' => $data ,
                'meta' => $meta ,
            ]);
        }else{
            return response()->json($data);
        }

    }

    protected function getUser($request)
    {

        return User::where('api_token', $request->token)->first();
    }


}
