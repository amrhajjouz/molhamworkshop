<?php

use App\Models\Cases;

function getLocaleName($locale)
{
    switch ($locale) {
        case 'ar':
            return 'عربي';
            break;
        case 'en':
            return 'انجليزي';
            break;
        case 'fr':
            return 'فرنسي';
            break;
        case 'de':
            return 'ألماني';
            break;
        case 'tr':
            return 'تركي';
            break;
        case 'es':
            return 'اسباني';
            break;
        default:
            return;
            break;
    }
}


function getAvailableLocales()
{
    return [
        'ar' => 'عربي',
        'en' => 'انجليزي',
        'fr' => 'فرنسي',
        'de' => 'ألماني',
        'tr' => 'تركي',
        'es' => 'اسباني',
    ];
}

function getCombinedCsv($csvPath, $header = null)
{
    $rows = array_map('str_getcsv', file($csvPath));
    $header = array_shift($rows);
    foreach ($header as $i => $key) $header[$i] = str_replace(' ', '_', strtolower($key));
    $csv = array();
    foreach ($rows as $row) {
        $csv[] = array_combine($header, $row);
    }
    return $csv;
}

function getCsvRows($csvPath)
{
    return array_map('str_getcsv', file($csvPath));
}
