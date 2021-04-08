<?php

namespace App\Models;

use App\Common\Base\BaseModel;
use App\Common\Traits\HasContent;

class Faq extends BaseModel
{
    use HasContent;


    protected $table = 'faqs';
    protected $guarded = [];


    /* 
     * Relation for this model with Content Model 
    */
    public function contents()
    {
        return $this->morphMany(\App\Models\Content::class, 'contentable');
    }

    public function category(){
        return $this->hasOne('App\Models\Category' , 'id' , 'category_id');
    }
    

    public function transform()
    {

        $constant = $this->toArray();

        $category = $this->category->name??null;

        return (object)array_merge($constant, [
            'contents' => getContent($this) ,
            'category' => [
                'name' => $category
            ],
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
