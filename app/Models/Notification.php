<?php

namespace App\Models;

use  Illuminate\Notifications\DatabaseNotification;

use App\Models\{NotificationTemplate};

class Notification extends DatabaseNotification
{
    protected $table = 'notifications';
    protected $guarded = [];
    protected $appends = ['description'];
    protected $casts = ['body' => 'json', 'data' => 'json'];
    public function getCreatedAtAttribute($date)
    {
        return date('Y-m-d H:i:s', strtotime($date));
    }

    public function getReadAtAttribute($date)
    {
        if (!$date) return null;
        return date('Y-m-d H:i:s', strtotime($date));
    }

    public function getDescriptionAttribute()
    {
        return $this->body[app()->getLocale()];
    }

    public function notifiable()
    {
        return $this->morphTo();
    }

    public function notificationTemplate()
    {
        return $this->belongsTo('App\Models\NotificationTemplate', 'type', 'name');
    }

    // public function save($options = [])
    // {
    //     $template = NotificationTemplate::where('name', $this->name)->firstOrFail();
    //     $this->template_id = $template->id;
    //     unset($this->name);
    //     // if ($template->path) {
    //         $patterns = $replacements = [];
    //         $reps = (array)$this->data;
    //         foreach ($reps as $key => $val) {
    //             $patterns[]     = '/\{' . $key . '\}/';
    //             $replacements[] = $val;
    //         }
    //         $data = $this->data;
    //         $data['path'] =  preg_replace($patterns, $replacements, $template->path);
    //         $this->body = [
    //             'en' => preg_replace($patterns, $replacements, $template->body['en']) ,
    //             'ar' => preg_replace($patterns, $replacements, $template->body['ar'])
    //         ];
    //         // $this->body['en'] =  preg_replace($patterns, $replacements, $template->body['en']);
    //         $this->data = $data;
    //     // }
    //     dd($this);
    //     return parent::save($options);
    // }

    public function save($options = [])
    {
        $template = NotificationTemplate::where('name', $this->name)->firstOrFail();
        unset($this->name);
        $this->template_id = $template->id;

        $allVariables = $replacements = $patterns = [];
        $matches = $this->extractString($template->path);
        if ($matches[1]) $allVariables = $matches[1];

        foreach ($template->body as $str) {
            $matches = $this->extractString($str);
            if ($matches[1]) foreach ($matches[1] as $m) $allVariables[] = $m;
        }
        
        $reps = (array)$this->data;
        foreach ($allVariables as $v) {
            if (!array_key_exists($v, $reps)){
                throw new \Exception('missed data');
            } 
            else{
                $replacements[$v] = $reps[$v];
                $patterns[]     = '/\{' . $v . '\}/';
            }
        }

        $this->body = ['en' => preg_replace($patterns, $replacements, $template->body['en']),'ar' => preg_replace($patterns, $replacements, $template->body['ar'])];
        $this->path = preg_replace($patterns, $replacements, $template->path);
        // dd($this->data , $replacements , array_diff_key( $replacements , $this->data));
        return parent::save($options);
    }

    protected function extractString($str)
    {
        preg_match_all("/\\{(.*?)\\}/", $str, $matches);
        return $matches ?? null;
    }
}
