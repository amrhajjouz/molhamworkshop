<?php

namespace App\Models;

use App\Common\Base\BaseModel;
use App\Common\Traits\HasContent;

class Publisher extends BaseModel
{
    use HasContent;
  

    protected $table = 'publishers';
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
            'name', 'description'
        ];
    }
}
