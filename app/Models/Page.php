<?php

namespace App\Models;

use App\Common\Base\BaseModel;
use App\Common\Traits\HasContent;

class Page extends BaseModel
{
    use HasContent;


    protected $table = 'pages';
    protected $guarded = [];

    public function transform()
    {

        $page = $this->toArray();


        return (object)array_merge($page, [
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
