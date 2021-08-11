<?php

use App\Models\ApiError;

function getLocaleName($locale)
{
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
        $apiError = ApiError::firstOrCreate(['code' => $response['error']], ['status' => isset($response['status']) ? $response['status'] : 400, 'message' => ['ar' => 'خطأ غير معروف', 'en' => 'Unkown Error']]);
        return response()->json(['error' => ['code' => $apiError->code, 'message' => $apiError->message[app()->getLocale()]]], $apiError->status);
    } elseif (is_array($response) && isset($response['errors'])) {
        $errors = [];
        foreach ($response['errors'] as $key => $value) {
            $errors[$key] = [];
            foreach ($value as $msg) {
                $apiError = ApiError::firstOrCreate(['code' => $msg], ['status' =>  400, 'message' => ['ar' => 'خطأ غير معروف', 'en' => 'Unkown Error']]);
                $errors[$key][] = ['code' => $msg, 'message' => $apiError->message[app()->getLocale()]];
            }
        }
        return response()->json(['errors' => $errors]);
    }
    return response()->json($response);
}
