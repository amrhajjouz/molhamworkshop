<?php

namespace App\Common\Traits;

trait HasActivityLog
{

    /* 
     * Relation for this model with ActivityLog Model 
    */


    public function activityLogs()
    {
        return $this->morphMany('App\Models\ActivityLog', 'loggable')->orderBy('id', 'desc');
    }


    public function activities()
    {
        return $this->morphMany('App\Models\ActivityLog', 'actor', 'actor_type', 'actor_id')->orderBy('id', 'desc');
    }




    // public function list_activity_logs()
    // {
    //     $activity_logs = $this->avtivity_logs;
    //     $result = [];
      
    //     foreach ($activity_logs as $log) {
    //         $result[] = array_merge($log->toArray(), [
    //             'actor' => [
    //                 'name' => $log->actor->name,
    //                 'email' => $log->actor->email,
    //             ],
    //             "activity" => [
    //                 "name" => $log->activity->toArray()['body_' . app()->getLocale()],

    //             ]
    //         ]);
    //     }

    //     return $result;
    // }

    
}
