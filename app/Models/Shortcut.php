<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\HasContent;

class Shortcut extends Model
{
    use HasContent;


    protected $table = 'shortcuts';
    protected $guarded = [];

    public function keys(){
        return $this->hasMany('App\Models\ShortcutKey' , 'shortcut_id' , 'id' );
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
        return ['title', 'description', ];
    }

    public function list_keywords()
    {
        $res = [];
        foreach ($this->keys as $key) {
            $key->contents = getContent($key);
            $res[] = $key;
        }
        return $res;  
    }
}
