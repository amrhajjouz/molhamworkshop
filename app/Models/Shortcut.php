<?php

namespace App\Models;

use App\Common\Base\BaseModel;
use App\Common\Traits\HasContent;

class Shortcut extends BaseModel
{
    use HasContent;


    protected $table = 'shortcuts';
    protected $guarded = [];

    public function keys(){
        return $this->hasMany('App\Models\ShortcutKey' , 'shortcut_id' , 'id' );
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
            'title', 'description', 
        ];
    }


    public function list_keywords()
    {
        $res = [];
        foreach ($this->keys as $key) {

            $key->contents = getContent($key);
            $res[] = $key;
            // foreach($key->contents  as $item){
            // }
            
        }
        // $keywords = $this->contents->where('name', 'keyword');
        return $res;  
    }
}
