<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\{HasContent };

class Blog extends Model
{
    use HasContent;
    protected $table = 'blogs';
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
        return [ 'title', 'description', 'body'];
    }
}
