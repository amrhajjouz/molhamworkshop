<?php

use App\Models\Activity;
use App\Models\ActivityLog;

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


function createActivityLog( $loggable , $activity_name  ,  $actor_type = "user" , $actor_id=null , $metadata=null){
        $activity = Activity::where('name' , $activity_name)->first();
        if(!$activity) return false;

        $log = new ActivityLog();
        
        $log->activity_id = $activity->id;
        $log->actor_type =  $actor_type;
        $log->actor_id =  $actor_id ?? auth()->id();

        if($metadata){
            $log->metadata =  $metadata;
        }

        return $loggable->avtivity_logs()->save($log);
    
    }