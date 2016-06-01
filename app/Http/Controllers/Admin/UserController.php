<?php namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Mail;
use Notification;

class UserController extends Controller
{
    /**
     * @var array
     */
    protected $rules = [
        'name' => ['required', 'max:255'],
        'email' => ['required', 'email', 'max:255'],
        'password' => ['min:6', 'confirmed'],
        'roles' => ['required', 'array'],
        'confirmed' => ['boolean'],
        'approved' => ['boolean'],
    ];

    /**
     * Display an index of users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.index', [
            'users' => User::orderBy('created_at', 'desc')->get()
        ]);
    }

    /**
     * Display a create user page.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->edit(new User);
    }

    /**
     * Store a user.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules + [
            'name' => ['unique:users'],
            'email' => ['unique:users'],
            'password' => ['required']
        ]);

        $user = User::create($request->only('name', 'email') + [
            'confirmed' => 1,
            'approved' => 1,
            'password' => bcrypt($request->input('password'))
        ]);

        foreach ($request->input('roles') as $id) {
            $role = Role::find($id);
            $user->roles()->attach($role);
        }

        $user->save();
        $user->profile()->create([]);

        $password = $request->input('password');

        Mail::send('admin.emails.user-created', compact('user', 'password'), function ($m) use ($user) {
            $m->to($user->email, $user->name)->subject('RNA account created');
        });

        Notification::success("User created. An email has been sent to the specified address notifying the user of their new account.");
        return redirect('admin/user');
    }

    /**
     * Display an edit user page.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'id');
        return view('admin.user.edit', compact('user', 'roles'));
    }

    /**
     * Update a user.
     *
     * @param  User  $user
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Request $request)
    {
        $this->validate($request, $this->rules + [
            'confirmed' => ['required'],
            'approved' => ['required']
        ]);

        $user->fill($request->only('name', 'email', 'confirmed', 'approved'));

        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        $user->roles()->detach();
        foreach ($request->input('roles') as $id) {
            $role = Role::find($id);
            $user->roles()->attach($role);
        }

        Notification::success("User updated.");
        return redirect('admin/user');
    }
}
