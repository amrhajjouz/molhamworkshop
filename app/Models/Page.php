<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\HasContent;

class Page extends Model
{
    use HasContent; 
    protected $table = 'pages';
    protected $guarded = [];

    public function transform()
    {
        return (object)array_merge($this->toArray(), ['contents' => getContent($this)]);
    }

    /* 
     * Abstracted from HasContent Trait 
     */
    public static function get_content_fields()
    {
        return ['title', 'description', 'body'];
    }
}
