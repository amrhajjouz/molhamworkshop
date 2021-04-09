<?php

namespace App\Models;

use App\Common\Base\BaseModel;
use App\Common\Traits\HasContent;

class Shortcut extends BaseModel
{
    use HasContent;


    protected $table = 'shortcuts';
    protected $guarded = [];

    public function transform()
    {

        $shortcut = $this->toArray();


        return (object)array_merge($shortcut, [
            'contents' => getContent($this) ,
        ]);
    }


    /* 
      * Abstracted from HasContent Trait 
     */
    public static function get_content_fields()
    {
        return [
            'title', 'description' , 'keyword'
        ];
    }


    public function list_keywords(){
       return  $keywords = $this->contents->where('name' , 'keyword');
    }
    

    
}
