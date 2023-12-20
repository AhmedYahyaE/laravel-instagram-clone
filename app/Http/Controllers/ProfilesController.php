<?php
// This controller was created by me using the command: `php artisan make:controller ProfilesController` to represent a one user profile data
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfilesController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
    */
    // Render index.blade.php page
    public function index(User $user)
    {
        $follows = auth()->user() ? auth()->user()->following->contains($user->id) : false; //    $follows    is always a Boolean (either true or false)    // auth()->user()->following->contains($user) returns a Boolean (meaning if the currently authenticated/logged-in user follows the passed in user id of the currently opened/displayed profile i.e. Check if the authenticated/logged-in user follows the currently opened/displayed profile)
        // dd($follows);


        // Laravel Caching:    // Cache: https://laravel.com/docs/9.x/cache
        $postCount = \Illuminate\Support\Facades\Cache::remember('count.posts.' . $user->id, now()->addSeconds(30), function() use ($user) {
            return $user->posts->count();
        });

        $followersCount = \Illuminate\Support\Facades\Cache::remember('count.followers.' . $user->id, now()->addSeconds(30), function() use ($user) {
            return $user->profile->followers->count();
        });

        $followingCount = \Illuminate\Support\Facades\Cache::remember('count.following.' . $user->id, now()->addSeconds(30), function() use ($user) {
            return $user->following->count();
        });


        
        return view('profiles/index', compact('user', 'follows', 'postCount', 'followersCount', 'followingCount'));
    }


    public function edit(User $user) { // render edit.blade.php page (GET Request)    // Route Model Binding: https://laravel.com/docs/9.x/routing#route-model-binding
        // Authorization of the Model Policy class that we created in ProfilePolicy.php class that governs our policy of Editing:
        $this->authorize('update', $user->profile); // authorize(policyMethod, the thing that the policy is applied on)


        return view('profiles/edit', compact('user'));
    }


    public function update(User $user) { // Update HTML Form Submission in edit.blade.php (POST Request)    // Route Model Binding: https://laravel.com/docs/9.x/routing#route-model-binding
        // Authorization of the Model Policy class that we created in ProfilePolicy.php class that governs our policy of Updating:
        $this->authorize('update', $user->profile); // YOU CAN'T CLICK SUBMIT UNLESS YOU'RE AUTHORIZED TO UPDATE!!

        // Validation of the <input> fields updated data:
        // We have two scenarios here, the user doesn't update their profile image (then we keep the old one), or the user updates their profile image by uploading a new one instead of the old one
        $data = request()->validate([
            'title'       => 'required',
            'description' => 'required',
            'url'         => 'url',
            'image'       => '' // the default is nothing (empty string)    // In case that the user updates their profile image by uploading a new one instead of the old one, the following $imageArray array (check the next couple lines of code) will be appended [] to the $data array, and the existing 'image' key/index will be replaced/overriden, and in case the user didn't update their profile image, the 'image' key remains as is
        ]);
        // dd($data);


        // If the user updates their profile image by uploading a new image instead of the old one
        if (request('image')) { // If the user opens the edit.blade.php page but doesn't update the image and then clicks Submit, we can assume that the old image is just fine with them
            // Store user-uploaded file (profile image) in Laravel's "storage" folder/directory, not in the "public" folder, and then to make those profile images "publicly accessible" or "web accessible", we create a Symbolic Link (shortcut) between the "public/storage" folder and "storage/app/public" folder by running the command "php artisan storage:link" (after configuring the 'link' array key/index in config/filesystems.php)
            // Note: The "php artisan storage:link" command depends on the 'link' array key/index value of "config/filesystems.php" file. N.B. You can create multiple "Symbolic Links" between multiple folders/directories by editing the value of the 'link' array key/index in config/filesystem.php file
            $imagePath = request('image')->store('profile', 'public');
            $image = \Intervention\Image\Facades\Image::make(public_path("/storage/{$imagePath}"))->fit(1000, 1000); // Intervention Image package
            $image->save();

            $imageArray = ['image' => $imagePath]; // This $imageArray array will be appended [] to the $data array in case that the user updates their profile image
        }

        // dd($data);
        // dd(array_merge($data, $imageArray ?? []));

        auth()->user()->profile->update(
            // if the user update their profile image by uploading a new image instead of the old one i.e. $imageArray is set, take it, or if not i.e. the user doesn't upldate their profile image (doesn't upload a new one instead of the old one), take the empty array (which won't override anything)
            array_merge($data, $imageArray ?? []) // the 'image' key in the second array, if present / if it exists (if the user tries to update their profile image by uploading a new one instead of the old one), the new 'image' key/index will override the already existing 'image' key in the $data array. But if the user doesn't upload a new image, the old existing 'image' array key/index remains.
        );


        return redirect("/profile/{$user->id}");
    }

}