<?php

namespace App\Models;

use App\Common\Base\BaseModel;
use App\Common\Traits\{HasContent , HasNote};

class Blog extends BaseModel
{
    use HasContent , HasNote;
  

    protected $table = 'blogs';
    protected $guarded = [];

    public function transform()
    { 

        $blog = $this->toArray();


        return (object)array_merge($blog, [
            'contents' => getContent($this),
        ]);
    }


    /* 
      * Abstracted from HasContent Trait 
     */
    public static function get_content_fields()
    {
        return [
            'title', 'description', 'body'
        ];
    }
}
