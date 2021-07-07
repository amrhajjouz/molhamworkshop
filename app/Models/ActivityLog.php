<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';
    protected $guarded = [];
    protected $appends = ['description'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    
    public function getDescriptionAttribute()
    {
        $activity = $this->activity->toArray();
        $body = $activity['body_'. app()->getLocale()];
        $patterns = $replacements = [];
        $reps = (array)$this->metadata;
        foreach ($reps as $key=>$val) {
            $patterns[]     = '/\{\{' . $key . '\}\}/';
            $replacements[] = $val;
        }
        return preg_replace($patterns, $replacements, $body);
    }
    
    public function loggable()
    {
        return $this->morphTo();
    }

    public function activity(){
        return $this->belongsTo('App\Models\Activity' , 'activity_id' , 'id');
    }

    public function actor(){
        return $this->morphTo(null , 'actor_type' , 'actor_id');
    }

    public function setMetadataAttribute($meta)
    {
        if(is_array($meta)) $this->attributes['metadata'] = json_encode($meta);
        else $this->attributes['metadata'] = $meta;
    }
   
    public function getMetadataAttribute($meta)
    {
        return json_decode($meta);
    }

    public function save($options = []){
        $activity = Activity::where('name' , $this->activity_name)->firstOrFail();
        $this->actor_id =  $this->actor_id ?? auth()->id();
        $this->activity_id = $activity->id;
        $this->actor_type = $this->actor_type ?? "user";
        unset($this->activity_name);
        return parent::save($options);
    }
    
}

