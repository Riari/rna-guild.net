<?php namespace App\Http\Controllers;

use Auth;
use App\Models\ImageAlbum;
use Illuminate\Http\Request;
use Image;
use Notification;

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
     * Display an image album creation page.
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

        foreach ($request->file('images') as $index => $image) {
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
                    'key' => "image.{$index}",
                    'title' => $request->input('image_captions')[$index]
                ]
            );
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
     * Get validation rules.
     *
     * @param  Request  $request
     * @return array
     */
    private function getRules(Request $request)
    {
        return [
            'title' => 'required',
            'images.*' => 'mimes:jpeg,gif,png|max:8000'
        ];
    }
}
