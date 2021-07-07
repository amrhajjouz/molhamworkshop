<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{Event , Activity};
class EventLog extends Model
{
    protected $table = 'event_logs';
    protected $guarded = [];
    protected $appends = ['description'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function getDescriptionAttribute()
    {
        $event = $this->event->toArray();
        $body = $event['body_'. app()->getLocale()];
        $patterns = $replacements = [];
        $reps = (array)$this->metadata;
        foreach ($reps as $key=>$val) {
            $patterns[]     = '/\{\{' . $key . '\}\}/';
            $replacements[] = $val;
        }
        return preg_replace($patterns, $replacements, $body);
    }
    
    public function eventable()
    {
        return $this->morphTo();
    }

    public function event(){
        return $this->belongsTo('App\Models\Event' , 'event_id' , 'id');
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
        $event = Event::where('name' , $this->event_name)->firstOrFail();
        $this->event_id = $event->id;
        if(isset($this->activity_name)){
            $activityId = Activity::where('name' , $this->activity_name)->firstOrFail()->id;
            $this->activity_id = $activityId;
            unset($this->activity_name);
        }
        unset($this->event_name);
        return parent::save($options);
    }
    
}

