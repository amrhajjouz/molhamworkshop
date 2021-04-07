<?php

namespace App\Models;

use App\Common\Base\BaseModel;

class Constant extends BaseModel
{

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
    

}
