<?php

use App\Models\Status;

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


function createStatus($statusable , $content){
        $status = $statusable->statuses()->save(new Status);
        $content = setContent($status, $content['name'], $content['value'], $content['locale']);

        return $status ;
}
