<?php

namespace App\Services;

use App\Models\Image;
// use Intervention\Image\ImageManagerStatic as InterventionImage;
use Illuminate\Support\Str;
// use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;

class ImageCreator
{
    public static function createImage($image, $data)
    {
        $reference = Str::random(10);
        do {
            $reference = Str::random(10);
        } while (Image::where('reference', $reference)->exists());
        $content = InterventionImage::make($image);
        // Save Image in its original size
        Storage::put('images/' . $reference . '.jpg', $content->stream());
        $content->backup();
        // Save Image in thumbnail sizes
        foreach (getImageThumbnailsSizes() as $s) {
            //create folder if not exists
            if (!file_exists(storage_path('images/' . $s[0] . 'x' . $s[1]))) {
                mkdir(storage_path('images/' . $s[0] . 'x' . $s[1]), 0777, true);
            }
            Storage::put('images/' . $s[0] . 'x' . $s[1] . '/' . $reference . '.jpg', $content->reset()->fit($s[0], $s[1])->stream());
        }
        $data['reference'] = $reference;
        return Image::create($data);
    }
}
