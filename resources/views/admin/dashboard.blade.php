@extends('admin.master')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
    <div class="col s12 m6 l3">
        <div class="card small" style="height:220px;">
            <div class="card-content">
                <span class="card-title">Articles</span>
                <p><strong>{{ $articles }}</strong> total</p>
            </div>
            <div class="card-action">
                <a href="{{ url('admin/article') }}">View articles</a>
            </div>
        </div>
    </div>
    <div class="col s12 m6 l3">
        <div class="card small" style="height:220px;">
            <div class="card-content">
                <span class="card-title">Events</span>
                <p>
                    <strong>{{ $events }}</strong> total
                    <br>
                    <span class="purple-text"><strong>{{ $eventsUpcoming }}</strong> upcoming</span>
                </p>
            </div>
            <div class="card-action">
                <a href="{{ url('admin/event') }}">View events</a>
            </div>
        </div>
    </div>
    <div class="col s12 m6 l3">
        <div class="card small" style="height:220px;">
            <div class="card-content">
                <span class="card-title">Forum Categories</span>
                <p><strong>{{ $forumCategories }}</strong> total</p>
            </div>
            <div class="card-action">
                <a href="{{ url('admin/forum/category') }}">View forum categories</a>
            </div>
        </div>
    </div>
    <div class="col s12 m6 l3">
        <div class="card small" style="height:220px;">
            <div class="card-content">
                <span class="card-title">Users</span>
                <p>
                    <strong>{{ $users }}</strong> total
                    <br>
                    <span class="orange-text"><strong>{{ $usersUnconfirmed }}</strong> unconfirmed</span>
                    <br>
                    <span class="red-text"><strong>{{ $usersUnapproved }}</strong> unapproved</span>
                </p>
            </div>
            <div class="card-action">
                <a href="{{ url('admin/user') }}">View users</a>
            </div>
        </div>
    </div>
</div>
@stop
