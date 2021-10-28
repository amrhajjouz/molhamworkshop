<?php

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
                    $apiError = ApiError::firstOrCreate(['code' => $response['error']]);
                    return response()->json(['error' => ['code' => $apiError->code, 'message' => $apiError->message[app()->getLocale()]]], $apiError->status);
          } elseif (is_array($response) && isset($response['errors'])) {
                    $errors = [];
                    foreach ($response['errors'] as $key => $value) {
                              $errors[$key] = [];
                              foreach ($value as $msg) {
                                        $apiError = ApiError::firstOrCreate(['code' => $msg]);
                                        $errors[$key][] = ['code' => $msg, 'message' => $apiError->message[app()->getLocale()]];
                              }
                    }
                    return response()->json(['error'=> collect($errors)->first()[0] ,'errors' => $errors ] , 400);
          }
          else return response()->json($response);
}

function getCombinedCsv ($csvPath, $header = null) {
    $rows = array_map('str_getcsv', file($csvPath));
    $header = array_shift($rows);
    foreach($header as $i => $key) $header[$i] = str_replace(' ', '_', strtolower($key));
    $csv = array();
    foreach ($rows as $row) {
        $csv[] = array_combine($header, $row);
    }
    return $csv;
}

function getCsvRows ($csvPath) {
    return array_map('str_getcsv', file($csvPath));
}
