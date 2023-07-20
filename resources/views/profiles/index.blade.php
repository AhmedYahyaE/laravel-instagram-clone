@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3 p-5">
                <img class="rounded-circle w-100" style=" width: 160px" src="{{ $user->profile->profileImage() }}" alt="">
            </div>
            <div class="col-9 pt-5">
                <div class="d-flex justify-content-between align-items-baseline">
                    <div class="d-flex align-items-center pb-3">
                        <div class="h4">{{ $user->username }}</div>

                        {{-- Show the Follow/Unfollow Button only if opened/current profile doens't belong to the currently authenticated/logged-in user i.e. Don't show the Follow/Unfollow Button on the personal profile of the logged-in user i.e. It's illogical that a user can Follow/Unfollow themselves --}}
                        @if (auth()->check()) {{-- If the current user is authenticated/logged-in --}}
                            @if ($user->id != auth()->user()->id) {{-- if the opened profile id is not equal to the id of the currently authenticated/logged-in user --}} {{-- Show the Follow/Unfollow Button only if the opened/displayed profile doesn't belong to the currently authenticated/logged-in user --}}
                                {{-- Vue Component (FollowButton.vue and Axios library). Check resources/js/components/FollowButton.vue and resources/js/app.js and public/js/app.js (which is included/imported in the layout of this View) --}}
                                {{-- When the button is clicked, a request is sent from the frontend (JavaScript/browser) to the server using Axios library ("user-id" and "follows" Boolean values are sent to the server during the Axios request) --}}
                                <follow-button user-id="{{ $user->id }}" follows="{{ $follows }}"></follow-button> {{-- user-id is a data field --}} {{-- $follows (a Boolean) and $user are variables passed in from the index() method in ProfilesController to the View here (index.blade.php) --}} {{-- Check the toggle() method inside the store() method in FollowsController.php --}}
                            @endif
                        @else {{-- If the current user is unauthenticated/logged-out/guest/visitor, show the Follow/Unfollow Button, but clicking on it will redirect the unauthenticated user to the login page (Check both the catch block of the Axios call in FollowButton.vue and the FollowsController.php where we applied the 'auth' middleware on the FollowsController.php in its constructor function) --}}
                            <follow-button user-id="{{ $user->id }}" follows="{{ $follows }}"></follow-button> {{-- user-id is a data field --}} {{-- $follows (a Boolean) and $user are variables passed in from the index() method in ProfilesController to the View here (index.blade.php) --}} {{-- Check the toggle() method inside the store() method in FollowsController.php --}}
                        @endif
                    </div>


                    {{-- Show "Add New Post" Button based on our ProfilePolicy.php (only if the authenticated user is the OWNER of the currently opened profile) --}}
                    @can('update', $user->profile) <!-- If the user can update the profile (depending on ProfilePolicy.php class and edit() method in ProfilesController.php) which means the user is the owner of the profile, the <a> will show up, otherwise, it will be hidden -->
                        <a href="/p/create">Add New Post</a>
                    @endcan


                </div>


                {{-- Show "Edit Profile" Button based on our ProfilePolicy.php (only if the authenticated user is the OWNER of the currently opened profile) --}}
                @can('update', $user->profile) <!-- If the user can update the profile (depending on ProfilePolicy.php class) which means the user is the ownser of the profile, the <a> will show up, otherwise, it will be hidden -->
                    <a href="/profile/{{ $user->id }}/edit">Edit Profile</a>
                @endcan


                <div class="d-flex">
                    {{-- Laravel Caching:    Cache: https://laravel.com/docs/9.x/cache --}} {{-- Check index() method in ProfilesController.php --}}
                    <div class="pe-5"><strong>{{ $postCount }}</strong> posts</div>
                    <div class="pe-5"><strong>{{ $followersCount }}</strong> followers</div>
                    <div class="pe-5"><strong>{{ $followingCount }}</strong> following</div>
                </div>
                <div class="pt-4 fw-bold">{{ $user->profile->title }}</div>
                <div>{{ $user->profile->description }}</div>
                <div><a href="#">{{ $user->profile->url }}</a></div>
            </div>
        </div>

        <div class="row pt-5">
            @foreach($user->posts as $post)
                <div class="col-4 pb-4">
                    <a href="/p/{{ $post->id }}">
                        <img class="w-100" src="/storage/{{ $post->image }}">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection