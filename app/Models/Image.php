<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;
    protected $table = 'images';
    protected $casts = ['deleted_at' => 'datetime:Y-m-d H:i:s', 'created_at' => 'datetime:Y-m-d H:i:s', 'updated_at' => 'datetime:Y-m-d H:i:s'];
    protected $guarded = [];
    protected $appends = ['url'];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function getUrlAttribute()
    {
        $urls = ['original' => url('images/' . $this->reference . '.jpg'), 'thumbnails' => []];
        foreach (getImageThumbnailsSizes() as $s) $urls['thumbnails'][$s[0] . 'x' . $s[1]] = url('images/' . $s[0] . 'x' . $s[1] . '/' . $this->reference . '.jpg');
        return $urls;
    }
}
