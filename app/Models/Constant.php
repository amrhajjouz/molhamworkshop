<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Constant extends Model
{

    protected $table = 'constants';
    protected $guarded = [];
    protected $casts= [
        'plaintext' => 'boolean'
    ];


    public function contents()
    {
        return $this->morphMany(\App\Models\Content::class, 'contentable');
    }

    
    public function transform()
    {
        $constant = $this->toArray();
        return (object)array_merge($constant, [
            'contents' => getContent($this) , 
        ]);
    }

    public static function get_content_fields(){
        return [
            'body'
        ];
    }
    
}
