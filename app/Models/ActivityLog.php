<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activiy_logs';
    protected $guarded = [];

    public function loggable()
    {
        return $this->morphTo();
    }

    public function activity(){
        return $this->belongsTo('App\Models\Activity' , 'activity_id' , 'id');
    }

    public function actor(){
        return $this->hasOne('App\Models\User' ,'id' ,'actor_id');
    }
    
    


    public function save($options = []){
        
        $this->actor_id = auth()->id();

        return parent::save();
    }
    

}

