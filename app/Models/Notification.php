<?php

namespace App\Models;

use  Illuminate\Notifications\DatabaseNotification;

use App\Models\{NotificationType};

class Notification extends DatabaseNotification
{
    protected $table = 'notifications';
    protected $guarded = [];
    // protected $casts = [
    //     'created_at' => 'datetime:Y-m-d H:i:s',
        // 'read_at' => 'datetime:Y-m-d H:i:s',
    // ];

    public function getCreatedAtAttribute($date){
        return date('Y-m-d H:i:s', strtotime($date));   
    }
    public function getReadAtAttribute($date){
        if(!$date) return null;
        return date('Y-m-d H:i:s', strtotime($date));   
    }
    
    // protected $dateFormat = 'Y-m-d H:i:s';


    protected $appends = ['description'];

    public function getDescriptionAttribute()
    {
        $type = $this->notificationsType->toArray();
        $body = $type['body_'. app()->getLocale()];
        $patterns = $replacements = [];
        $reps = (array)$this->data;
        foreach ($reps as $key=>$val) {
            $patterns[]     = '/\{\{' . $key . '\}\}/';
            $replacements[] = $val;
        }
        unset($this->notificationsType);
        return preg_replace($patterns, $replacements, $body);
    }
    
    public function notifiable()
    {
        return $this->morphTo();
    }

   public function notificationsType(){
        return $this->belongsTo('App\Models\NotificationType', 'type', 'name');
   }

    public function save($options = []){
        $type = NotificationType::where('name' , $this->type)->firstOrFail();
        if($type->path){
            $patterns = $replacements = [];
            $reps = (array)$this->data;
            foreach ($reps as $key => $val) {
                $patterns[]     = '/\{\{' . $key . '\}\}/';
                $replacements[] = $val;
            }
            $data = $this->data;
            $data['path'] =  preg_replace($patterns, $replacements, $type->path);
            $this->data = $data;
        }
        return parent::save($options);
    }
    
}

