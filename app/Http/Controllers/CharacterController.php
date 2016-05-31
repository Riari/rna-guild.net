<?php namespace App\Http\Controllers;

use Auth;
use App\Models\Character;
use App\Models\CharacterClass;
use App\Support\Image;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Notification;
use Storage;

class CharacterController extends Controller
{
    /**
     * Display a character index.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paginator = Character::orderBy('name')->paginate(24);
        return view('character.index', compact('paginator'));
    }

    /**
     * Display a character.
     *
     * @param  Character  $character
     * @return \Illuminate\Http\Response
     */
    public function show(Character $character)
    {
        return view('character.show', compact('character') + [
            'commentPaginator' => $character->comments()->orderBy('created_at', 'desc')->paginate()
        ]);
    }

    /**
     * Display a character creation page.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('createCharacters');
        return $this->edit(new Character);
    }

    /**
     * Create a new character.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('createCharacters');
        $this->validate(
            $request,
            ['name' => ['required', 'regex:/(?=[a-zA-Z_]+\d{0,4}$)^[A-Z][a-zA-Z0-9]*(?:_[A-Z])?[a-zA-Z0-9]*$/', 'min:3', 'max:16', 'unique:characters']]
            + $this->getRules($request)
        );

        $character = Character::create([
            'user_id' => Auth::id()
        ] + $request->only('class_id', 'name', 'age', 'occupation', 'description', 'main'));

        if ($request->hasFile('portrait')) {
            $this->processImage($character, $request->file('portrait'));
        }

        Notification::success("Character added successfully");

        return redirect($character->url);
    }

    /**
     * Display a character editing page.
     *
     * @param  Character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Character $character)
    {
        if ($character->exists) {
            $this->authorize($character);
        }

        $classes = CharacterClass::pluck('name', 'id');
        return view('character.edit', compact('character', 'classes'));
    }

    /**
     * Update a character.
     *
     * @param  Character  $character
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Character $character, Request $request)
    {
        $this->authorize('edit', $character);
        $this->validate($request, $this->getRules($request));

        if ($request->hasFile('portrait')) {
            $portrait = $character->findAttachmentByKey('portrait');
            if (!is_null($portrait)) {
                $portrait->delete();
            }
            $this->processImage($character, $request->file('portrait'));
        }

        if ($request->has('main') && $request->input('main') == true) {
            $existingMain = Character::byUser($character->user)->where('main', 1)->first();

            if (!is_null($existingMain)) {
                $existingMain->main = 0;
                $existingMain->save();
            }
        }

        $character->update($request->only('class_id', 'age', 'occupation', 'description', 'main'));

        Notification::success("Character updated successfully");

        return redirect($character->url);
    }

    /**
     * Delete a character.
     *
     * @param  Character  $character
     * @return \Illuminate\Http\Response
     */
    public function delete(Character $character)
    {
        $this->authorize($character);
        $character->delete();

        Notification::success("Character deleted");

        return redirect('characters');
    }

    /**
     * Handle an uploaded image.
     *
     * @param  Character  $character
     * @param  UploadedFile  $image
     * @return string
     */
    private function processImage(Character $character, UploadedFile $image)
    {
        $filename = Image::process($image, [300, 390], 'characters', $character->id);
        $character->attach($filename, ['key' => 'portrait']);
        return $character;
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
            'class_id' => ['required', 'exists:character_classes,id'],
            'portrait' => ['mimes:jpeg,gif,png', 'max:8000']
        ];
    }
}
