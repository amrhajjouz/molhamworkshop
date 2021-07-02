<?php

namespace App\Traits;

trait HasEventLog
{

    /* 
     * Relation for this model with ActivityLog Model 
    */

    public function eventLogs()
    {
        return $this->morphMany('App\Models\EventLog', 'eventable')->orderBy('id', 'desc');
    }

    
}
