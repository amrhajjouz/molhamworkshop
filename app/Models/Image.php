<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Intervention\Image\Facades\Image as InterventionImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
        $cdnUrl = 'https://cdn.molhamteam.com/images/';
        $urls = ['original' => $cdnUrl . $this->reference . '.jpg', 'thumbnails' => []];
        foreach (getImageThumbnailsSizes() as $s) $urls['thumbnails'][$s[0] . 'x' . $s[1]] = $cdnUrl . $s[0] . 'x' . $s[1] . '/' . $this->reference . '.jpg';
        return $urls;
    }

    public function save($options = [])
    {
        if (!$this->exists) {
            do {$this->reference = Str::random(100);} while (Image::where('reference', $this->reference)->exists());
            $image = InterventionImage::make($this->image); //save original size
            Storage::put('images/' . $this->reference . '.jpg', $image->stream());
            $image->backup();
            foreach (getImageThumbnailsSizes() as $s) Storage::put('images/' . $s[0] . 'x' . $s[1] . '/' . $this->reference . '.jpg', $image->reset()->fit($s[0], $s[1])->stream()); //save thumbnails
            unset($this->image);
        }
        return parent::save($options);
    }
}
