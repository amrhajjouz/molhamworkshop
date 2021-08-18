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

    public function save($options = [])
    {
        if (!$this->exists) {
            $template = NotificationTemplate::where('name', $this->name)->firstOrFail();
            unset($this->name);
            $this->template_id = $template->id;
            $allVariables = $replacements = $patterns = [];
            $matches = extractVariables($template->path);
            if ($matches) $allVariables = $matches;
            foreach ($template->body as $str) {
                $matches = extractVariables($str);
                if ($matches) foreach ($matches as $m) $allVariables[] = $m;
            }
            foreach ($allVariables as $v) {
                if (!array_key_exists($v, $this->data)) {
                    throw new \Exception('missed data');
                } else {
                    $replacements[$v] = $this->data[$v];
                    $patterns[]     = '/\{' . $v . '\}/';
                }
            }
            $notificationBody = [];
            foreach ($template->body as $key => $value) {
                $notificationBody[$key] = fillVariables($template->body[$key], $replacements);
            }
            $this->body = $notificationBody;
            $this->path = fillVariables($template->path, $replacements);;
        }
        return parent::save($options);
    }
}
