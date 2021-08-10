<?php

use App\Models\ApiError;

function getLocaleName ($locale) {
    switch ($locale) {
        case 'ar' : return 'عربي'; break;
        case 'en' : return 'انجليزي'; break;
        case 'fr' : return 'فرنسي'; break;
        case 'de' : return 'ألماني'; break;
        case 'tr' : return 'تركي'; break;
        case 'es' : return 'اسباني'; break;
        default: return ; break;
    }
}



function handleResponse($response)
{
    if (is_array($response) && isset($response['error'])) {
        $apiError = ApiError::firstOrCreate(['code' => $response['error'] ], [ 'status' => isset($response['status']) ? $response['status'] : 400  ,'message' => ['ar' => 'خطأ غير معروف' , 'en' => 'Unkown Error'] ] );
        return response()->json(['error' => ['code' => $apiError->code ,'message'=> $apiError->message[app()->getLocale()] ]], $apiError->status );
    }
    return response()->json($response);
}