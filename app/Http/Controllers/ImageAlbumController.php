<?php namespace App\Http\Controllers;

use Auth;
use App\Models\ImageAlbum;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Image;
use Notification;
use Storage;

class ImageAlbumController extends Controller
{
    /**
     * Display an image album index.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paginator = ImageAlbum::orderBy('created_at', 'desc')->paginate(24);
        return view('image-album.index', compact('paginator'));
    }

    /**
     * Display an image album.
     *
     * @param  ImageAlbum  $event
     * @return \Illuminate\Http\Response
     */
    public function show(ImageAlbum $album)
    {
        return view('image-album.show', compact('album') + [
            'commentPaginator' => $album->comments()->orderBy('created_at', 'desc')->paginate()
        ]);
    }

    /**
     * Display an image album creation page.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->edit(new ImageAlbum);
    }

    /**
     * Create a new image album.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->getRules($request));

        $album = ImageAlbum::create([
            'user_id' => Auth::id()
        ] + $request->only('title', 'description'));

        foreach ($request->file('image_files') as $index => $image) {
            $this->processImage($album, $image, $index, $request->input('image_captions')[$index]);
        }

        Notification::success("Image(s) uploaded successfully");

        return redirect($album->url);
    }

    /**
     * Display an image album editing page.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ImageAlbum $album)
    {
        return view('image-album.edit', compact('album'));
    }

    /**
     * Update an image album.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(ImageAlbum $album, Request $request)
    {
        $this->validate($request, $this->getRules($request));

        $images = $request->file('image_files');
        $captions = $request->input('image_captions');

        // Delete removed images first
        foreach ($album->attachments as $attachment) {
            if (!array_key_exists($attachment->key, $images)) {
                $attachment->delete();
            }
        }

        // Update existing images and add new ones
        foreach ($images as $index => $image) {
            $attachment = $album->attachments()->key($index)->first();
            $caption = $request->input('image_captions')[$index];

            if (!is_null($image)) {
                if (!is_null($attachment)) {
                    $attachment->delete();
                }

                $this->processImage($album, $image, $index, $caption);
            } elseif (!is_null($attachment) && $attachment->title != $caption) {
                $attachment->title = $caption;
                $attachment->save();
            }
        }

        $album->update($request->only('title', 'description'));

        Notification::success("Image album updated successfully");

        return redirect($album->url);
    }

    /**
     * Delete an image album.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(ImageAlbum $album)
    {
        $album->delete();

        rmdir(config('filer.path.absolute') . "/albums/{$album->id}");

        Notification::success("Image album deleted successfully");

        return redirect('gallery');
    }

    /**
     * Handle an uploaded image.
     *
     * @param  ImageAlbum  $album
     * @param  UploadedFile  $image
     * @param  int  $index
     * @param  string  $caption
     * @return string
     */
    private function processImage(ImageAlbum $album, UploadedFile $image, $index, $caption)
    {
        $destination = config('filer.path.absolute');
        $path = "albums/{$album->id}";
        $filename = "{$path}/{$index}.{$image->guessExtension()}";

        if (!is_dir("{$destination}/{$path}")) {
            mkdir("{$destination}/{$path}");
        }

        Image::make($image)
            ->fit(1920, 1080, function ($constraint) {
                $constraint->upsize();
            })
            ->save("{$destination}/{$filename}");

        $album->attach(
            $filename,
            [
                'key' => $index,
                'title' => $caption
            ]
        );

        return $album;
    }

    /**
     * Get validation rules.
     *
     * @param  Request  $request
     * @return array
     */
    private function getRules(Request $request)
    {
        return [
            'title' => 'required',
            'image_files.*' => 'mimes:jpeg,gif,png|max:8000'
        ];
    }
}