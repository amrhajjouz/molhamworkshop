<?php

namespace App\Traits;

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

    
}
