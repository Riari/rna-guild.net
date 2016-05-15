<?php namespace App\Http\Controllers\Auth;

use Auth;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserActivation;
use App\Models\UserAuth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Mail;
use Notification;
use Session;
use Socialite;
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
        $this->middleware($this->guestMiddleware(), ['except' => 'getLogout']);
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

        if (!in_array($provider, ['facebook', 'google', 'twitter'])) {
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
        $provider = $request->route('provider');

        if (!in_array($provider, ['facebook', 'google', 'twitter'])) {
            return redirect('auth/login');
        }

        $socialiteUser = Socialite::driver($provider)->user();

        $auth = UserAuth::where([
            'provider' => $provider,
            'provider_user_id' => $socialiteUser->id
        ])->first();

        if (is_null($auth)) {
            Session::flash('pending_user_auth', $socialiteUser);
            Session::flash('pending_user_auth_provider', $provider);
            return redirect('auth/register');
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
        if (!$user->activated) {
            Auth::logout();
            Notification::warning("Your account is not active. :(");
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
        Auth::logout();
        Notification::success("You are now logged out.");
        return redirect('/');
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

        // Create an activation token
        $activation = UserActivation::createForUser($user);

        // Send it with the activation email
        Mail::send('auth.emails.activation', compact('user', 'activation'), function ($m) use ($user) {
            $m->to($user->email, $user->name)->subject('TRN account activation');
        });

        Notification::success("Thanks for registering, {$user->name}! An account activation link has been sent to {$user->email}.");

        // If there's a pending user auth, create it
        if (Session::has('pending_user_auth')) {
            $socialiteUser = Session::pull('pending_user_auth');
            $provider = Session::pull('pending_user_auth_provider');
            $auth = UserAuth::createFromSocialite($user, $provider, $socialiteUser);
            Notification::success("Your TRN account has been linked to {$provider}.");
        }

        return redirect('/');
    }

    /**
     * Show the account activation form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getActivation(Request $request)
    {
        $activation = UserActivation::forToken($request->route('token'))->first();

        if (is_null($activation)) {
            Notification::info("Invalid token. Maybe the link you followed is old?");
            return redirect('/');
        }

        return view('auth.activation', compact('activation'));
    }

    /**
     * Handle an account activation request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postActivation(Request $request)
    {
        $activation = UserActivation::forToken($request->input('token'))->first();

        if (is_null($activation)) {
            Notification::info("Invalid token. Maybe the link you followed is old?");
            return redirect('/');
        }

        $activation->user->activate();
        $activation->delete();

        Notification::success("Account {$activation->user->name}/{$activation->user->email} successfully activated. You are now logged in. :D");
        Auth::login($activation->user);

        return redirect('/');
    }
}
