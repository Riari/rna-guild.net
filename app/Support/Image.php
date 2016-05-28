<?php namespace App\Support;

use Illuminate\Http\UploadedFile;
use Image as InterventionImage;

class Image
{
    /**
     * Process and store an image via Filer.
     *
     * @param  UploadedFile  $image
     * @param  array  $dimensions
     * @param  string  $path
     * @param  string|int  $key
     * @return string
     */
    public static function process(UploadedFile $image, $dimensions, $path, $key = '')
    {
        $destination = config('filer.path.absolute');
        $filename = "{$path}/{$key}.{$image->guessExtension()}";

        if (!is_dir("{$destination}/{$path}")) {
            mkdir("{$destination}/{$path}");
        }

        InterventionImage::make($image)
            ->fit($dimensions[0], $dimensions[1], function ($constraint) {
                $constraint->upsize();
            })
            ->save("{$destination}/{$filename}");

        return $filename;
    }
}
