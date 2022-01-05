<?php
function getLocaleName($locale)
{
    switch ($locale) {
        case 'ar' :
            return 'عربي';
            break;
        case 'en' :
            return 'انجليزي';
            break;
        case 'fr' :
            return 'فرنسي';
            break;
        case 'de' :
            return 'ألماني';
            break;
        case 'tr' :
            return 'تركي';
            break;
        case 'es' :
            return 'اسباني';
            break;
        default:
            return;
            break;
    }
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

function userExperienceCount($userId, $contract_start_date, $contract_end_date)
{
    $user = \App\Models\User::where('id',$userId)->first();
    $newDuration = contractPeriod($contract_start_date, $contract_end_date);
    $userExperience = ($user->total_experience ?? 0) + $newDuration;
    if ($userExperience > 0) {
        $user->total_experience = $userExperience;
        $user->save();
    }
}

function contractPeriod($contract_start_date, $contract_end_date)
{
    $to = \Carbon\Carbon::parse($contract_start_date)->format('Y-m-d H:s:i');
    $from =  \Carbon\Carbon::parse($contract_end_date)->format('Y-m-d H:s:i');
    $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $to);
    $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $from);
    $diff_in_months = $to->diffInMonths($from);
    return $diff_in_months;
}