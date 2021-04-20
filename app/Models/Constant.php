<?php

namespace App\Models;

use App\Common\Base\BaseModel;

class Constant extends BaseModel
{

    protected $table = 'constants';
    protected $guarded = [];
    protected $casts= [
        'plaintext' => 'boolean'
    ];


    /* 
     * Relation for this model with Content Model 
    */
    public function contents()
    {
        return $this->morphMany(\App\Models\Content::class, 'contentable');
    }

    
    public function transform()
    {
        // dd(array_key_first(getContent($this)));
        // dd(["name" =>getContent($this)]);

        $constant = $this->toArray();

        return (object)array_merge($constant, [
            // 'contents' =>[
            //     "name" => array_key_first(getContent($this)) ,  
            //     'content_value' => getContent($this)

            // ]

            'contents' => getContent($this) , 
            'content_name' => array_key_first(getContent($this)) 
        ]);
    }


    public static function get_content_fields(){
        return [
            '*'
        ];
    }
    
    // name , 
}
