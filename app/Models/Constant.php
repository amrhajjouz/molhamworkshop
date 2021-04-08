<?php

namespace App\Models;

use App\Common\Base\BaseModel;

class Faq extends BaseModel
{

    protected $table = 'faqs';
    protected $guarded = [];


    /* 
     * Relation for this model with Content Model 
    */
    public function contents()
    {
        return $this->morphMany(\App\Models\Content::class, 'contentable');
    }



    public function transform(){
        
        $constant = $this->toArray();

        return(object)array_merge($constant , [
            'contents'=>$this->contents
        ]);
    }
    

}
