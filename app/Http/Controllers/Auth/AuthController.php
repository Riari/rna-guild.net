<?php namespace App\Http\Controllers\Auth;

use Auth;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserConfirmation;
use App\Models\UserAuth;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Mail;
use Notification;
use Session;
use Socialite;
use URL;
use Validator;

class AuthController extends Controller
{
    use AuthenticatesUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), [
            'except' => ['redirectToProvider', 'handleProviderCallback', 'getLogout']
        ]);
    }

    /**
     * Redirect the user to a given provider's authentication page.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider(Request $request)
    {
        $provider = $request->route('provider');

        if (!isset(config('auth.login_providers')[$provider])) {
            return redirect('auth/login');
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request)
    {
        if (!$request->has('code') || $request->has('denied')) {
            return redirect('auth/login');
        }

        $provider = $request->route('provider');

        if (!isset(config('auth.login_providers')[$provider])) {
            return redirect('auth/login');
        }

        $socialiteUser = Socialite::driver($provider)->user();

        $auth = UserAuth::where([
            'provider' => $provider,
            'provider_user_id' => $socialiteUser->id
        ])->first();

        if (is_null($auth)) {
            if (Auth::guest()) {
                Session::flash('pending_user_auth', $socialiteUser);
                Session::flash('pending_user_auth_provider', $provider);
                return redirect('auth/register');
            } else {
                UserAuth::createFromSocialite(Auth::user(), $provider, $socialiteUser);
                Notification::success("Your {$provider} account is now connected and you can log in with it from now on.");
                return redirect('account/settings');
            }
        } else {
            Auth::login($auth->user);
            Notification::success("Welcome back, {$auth->user->name}!");
            return redirect('/');
        }
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, ['name_or_email' => 'required']);

        $field = filter_var($request->input('name_or_email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        $request->merge([$field => $request->input('name_or_email')]);
        $this->username = $field;

        return self::login($request);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, User $user)
    {
        if (!$user->confirmed) {
            Auth::logout();
            Notification::warning("Your account is not active. :( Check your emails for the activation email that was sent, or ask an officer to confirm your account for you.");
            return back();
        }

        Notification::success("Welcome back, {$user->name}!");
        return redirect()->intended('/');
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        if (!empty(URL::previous()) && !str_contains(URL::previous(), 'auth/')) {
            $this->redirectAfterLogout = URL::previous();
        }

        Notification::success("You are now logged out.");

        return $this->logout();
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        Session::keep(['pending_user_auth', 'pending_user_auth_provider']);
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegister(Request $request)
    {
        Session::keep(['pending_user_auth', 'pending_user_auth_provider']);

        $this->validate($request, [
            'name' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);

        // Given them the default role
        $user->roles()->attach(Setting::get('default_role', 3));

        // Give the user a profile
        $user->profile()->create([]);

        // Create an activation token
        $confirmation = UserConfirmation::createForUser($user);

        // Send it with the confirmation email
        Mail::send('auth.emails.confirmation', compact('user', 'confirmation'), function ($m) use ($user) {
            $m->to($user->email, $user->name)->subject('RNA account confirmation');
        });

        Notification::success("Thanks for registering, {$user->name}! An account confirmation link has been sent to {$user->email}.");

        // If there's a pending user auth, create it
        if (Session::has('pending_user_auth')) {
            $socialiteUser = Session::pull('pending_user_auth');
            $provider = Session::pull('pending_user_auth_provider');
            $auth = UserAuth::createFromSocialite($user, $provider, $socialiteUser);
            Notification::success("Your RNA account has been linked to {$provider}.");
        }

        return redirect('/');
    }

    /**
     * Show the account confirmation form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getConfirmation(Request $request)
    {
        $confirmation = UserConfirmation::forToken($request->route('token'))->first();

        if (is_null($confirmation)) {
            Notification::info("Invalid token. Maybe the link you followed is old?");
            return redirect('/');
        }

        return view('auth.confirmation', compact('confirmation'));
    }

    /**
     * Handle an account confirmation request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postConfirmation(Request $request)
    {
        $confirmation = UserConfirmation::forToken($request->input('token'))->first();

        if (is_null($confirmation)) {
            Notification::info("Invalid token. Maybe the link you followed is old?");
            return redirect('/');
        }

        $confirmation->user->confirm();
        $confirmation->delete();

        Notification::success("Account {$confirmation->user->name}/{$confirmation->user->email} successfully confirmed. You are now logged in. :D");
        Auth::login($confirmation->user);

        return redirect('/');
    }
}
