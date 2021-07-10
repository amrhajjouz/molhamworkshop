<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\HasContent;

class ShortcutKey extends Model
{
    use HasContent;
    protected $table = 'shortcut_keys';
    protected $guarded = [];

    public function shortcut(){
        return $this->belongsTo('App\Models\Shortcut' , 'shortcut_id' , 'id');
    }

    public function contents()
    {
        return $this->morphMany(\App\Models\Content::class, 'contentable')->orderBy('id', 'desc');
    }
    public function content()
    {
        return $this->morphOne(\App\Models\Content::class, 'contentable')->orderBy('id', 'desc');
    }

    public function transform()
    {
        return (object)array_merge($this->toArray(), ['contents' => getContent($this),]);
    }
    /* 
      * Abstracted from HasContent Trait 
     */
    public static function get_content_fields()
    {
        return ['keyword'];
    }

}
