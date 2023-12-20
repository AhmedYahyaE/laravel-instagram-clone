<?php
// A controller for the Follow/Unfollow Button in index.blade.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class FollowsController extends Controller
{

    public function __construct() { // Adding this route to the Protected Routes by applying the middleware 'Auth' (authentication (meaning logged-in)) on this whole FollowsController or Route, i.e.  meaning a user must be authenticated/logged-in to be able to follow another profile
        $this->middleware('auth');
    }

    // "Follow/Unfollow" Button Axios call
    public function store(User $user) { // $user is the the user who will be followed by the authenticated user
        return auth()->user()->following()->toggle($user->profile); // toggle attach() and detach() in the intermediate/pivot table (toggle addind/removing records in the intermediate table/pivot table)    // Check the following() method in User.php model   // The auth()->user() returns the authenticated user (the user who wants to follow), while toggle() is called on the user \App\Models\User::class which is the user which will be followed by that authenticated user
    }

}