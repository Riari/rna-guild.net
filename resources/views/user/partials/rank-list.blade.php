@foreach ($user->roles as $role)
    <strong style="color:{{ $role->colour }}">{{ $role->name }}</strong><br>
@endforeach
