<?php

namespace App\Models;

use App\Common\Traits\HasContent;


use App\Common\Base\BaseModel;

class Status extends BaseModel
{
     use HasContent;

     protected $table = 'statuses';
     protected $guarded = [];



     public function targetable()
     {
          return $this->morphTo();
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
               'status'
          ];
     }
}
