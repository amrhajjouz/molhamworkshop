<?php

namespace App\Models;

use App\Common\Base\BaseModel;
use App\Common\Traits\HasContent;

class Constant extends BaseModel
{
    use HasContent;


    protected $table = 'constants';
    protected $guarded = [];
    protected $casts = [
        'plaintext' => 'boolean' 
    ];


    /* 
     * Relation for this model with Content Model 
    */
    public function content()
    {
        return $this->morphOne(\App\Models\Content::class, 'contentable');
    }



    public function transform(){
        
        $constant = $this->toArray();

        return(object)array_merge($constant , [
            'content'=>$this->content
        ]);
    }


    /* 
      * Abstracted from HasContent Trait 
     */
    public static function get_content_fields()
    {
        return [
            'question', 'answer'
        ];
    }

}
