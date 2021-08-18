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

function extractStringVariables($string)
{
    preg_match_all("/\\{(.*?)\\}/", $string, $matches);
    return $matches[1] ?? null;
}

function fillStringVariables($string, $data)
{
    $patterns = [];
    foreach ($data as $key => $value) { $patterns[]     = '/\{' . $key . '\}/'; }
    return preg_replace ($patterns, $data, $string);
}