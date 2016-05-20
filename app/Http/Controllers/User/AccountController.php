<?php namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserAuth;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Mail;
use Image;
use Notification;

class AccountController extends Controller
{
    /**
     * Create a new account controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the account settings page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getSettings(Request $request)
    {
        $auths = UserAuth::byUser(Auth::user())->get();
        return view('user.account.settings', compact('auths'));
    }

    /**
     * Handle an account settings request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postSettings(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'confirmed|min:6'
        ]);

        $user = $request->user();

        if (!Hash::check($request->input('current_password'), $user->password)) {
            Notification::error("Incorrect current password entered. Please try again.");
            return redirect('account/settings');
        }

        if ($request->has('email')) {
            $email = $request->input('email');
            Mail::send('account.emails.email-changed', compact('user', 'email'), function ($m) use ($user) {
                $m->to($user->email, $user->name)->subject('RNA account email address changed');
            });
            $user->email = $email;
            Notification::success("Email address updated.");
        }

        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
            Notification::success("Password updated.");
            Mail::send('account.emails.password-changed', compact('user'), function ($m) use ($user) {
                $m->to($user->email, $user->name)->subject('RNA account password changed');
            });
        }

        $user->save();

        return redirect('account/settings');
    }

    /**
     * Show the login disconnection page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getDisconnectLogin(Request $request)
    {
        $key = $request->route('provider');
        $providers = config('auth.login_providers');

        if ($provider = $providers[$key]) {
            return view('user.account.disconnect-login', compact('key', 'provider'));
        }

        return redirect('account/settings');
    }

    /**
     * Handle a provider login disconnection request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postDisconnectLogin(Request $request)
    {
        $key = $request->route('provider');
        $providers = config('auth.login_providers');

        if ($provider = $providers[$key]) {
            $auth = UserAuth::byUser(Auth::user())->forProvider($key)->delete();
            Notification::success("Your {$provider} login has been disconnected.");
        }

        return redirect('account/settings');
    }

    /**
     * Redirect to the user's profile.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function redirectToProfile(Request $request)
    {
        return redirect()->route('user.profile', [
            'id'    => Auth::user()->id,
            'name'  => str_slug(Auth::user()->name, '-')
        ]);
    }

    /**
     * Show the profile edit page.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getEditProfile(Request $request)
    {
        return view('user.profile.edit', ['user' => $request->user()]);
    }

    /**
     * Handle a profile edit request.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postEditProfile(Request $request)
    {
        $config = config('image.avatars');

        $this->validate($request, [
            'avatar' => "mimes:jpeg,gif,png|max:{$config['max_size']}"
        ]);

        $profile = $request->user()->profile;
        $profile->update($request->only('about', 'signature'));

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $file = $request->file('avatar');
            $destination = config('filer.path.absolute');
            $filename = 'avatars/' . Auth::id() . '.' . $file->guessExtension();
            Image::make($request->file('avatar'))
                ->resize($config['dimensions'][0], $config['dimensions'][1])
                ->save("{$destination}/{$filename}");

            $profile->attach($filename, ['key' => 'avatar']);
        }

        Notification::success("Profile updated.");
        return redirect('account/profile/edit');
    }
 }
