<?php

namespace App\Models;

use App\Common\Base\BaseModel;
use App\Common\Traits\HasContent;

class ShortcutKey extends BaseModel
{
    use HasContent;


    protected $table = 'shortcut_keys';
    protected $guarded = [];



    public function shortcut(){
        return $this->belongsTo('App\Models\Shortcut' , 'shortcut_id' , 'id');
    }

    public function contents()
    {
        // return null;
        return $this->morphMany(\App\Models\Content::class, 'contentable')->orderBy('id', 'desc');
    }
    public function content()
    {
        return $this->morphOne(\App\Models\Content::class, 'contentable')->orderBy('id', 'desc');
    }

    public function transform()
    {

        $shortcut = $this->toArray();


        return (object)array_merge($shortcut, [
            'contents' => getContent($this),
        ]);
    }


    /* 
      * Abstracted from HasContent Trait 
     */
    public static function get_content_fields()
    {
        return [
            'keyword'
        ];
    }

}
