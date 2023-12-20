<?php
// This is a controller for posts.

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostsController extends Controller
{

    public function __construct() {
        $this->middleware('auth'); // Register the 'auth' middleware to the entire PostsController to add the route (in web.php) and add that whole Posts Controller to the Protected Routes to prevent accessing the controller methods unless being authenticated (logged-in), because you can't create or submit a post unless there's an authenticated (logged-in) user.
    }


    public function index() { // Showing the latest posts from all the profiles a user is following in sequential order
        $users = auth()->user()->following()->pluck('profiles.user_id'); // grab the 'user_id'-s of the profiles that the authenticated (logged-in) user is following
        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5); // Paginatin    // grab the posts of the profiles the user is following depending on descending created_at date    // Eager Loading: https://laravel.com/docs/9.x/eloquent-relationships#eager-loading    // Eager Loading with the 'user' relationship method name in Post.php model    // orderBy('created_at', 'DESC') is the same as latest()   // Note that $users is already user_id-s
        // dd($posts);


        return view('posts/index', compact('posts')); // pass $posts to the view
    }


    public function create() { // render create.blade.php file
        return view('posts/create');
    }


    public function store() { // HTML Form Submission in create.blade.php
        // Validation:
        $data = request()->validate([
            // listing the 'name' attributes in the form <input> fields in create.blade.php
            'caption' => 'required',
            'image'   => 'required|image'
        ]);
        // dd($data);


        // Store user-uploaded file (image) in Laravel's "storage" folder/directory, not in the "public" folder, and then to make those images "publicly accessible" or "web accessible", we create a Symbolic Link (shortcut) between the "public/storage" folder and "storage/app/public" folder by running the command "php artisan storage:link" (after configuring the 'link' array key/index in config/filesystems.php)
        // Note: The "php artisan storage:link" command depends on the 'link' array key/index value of "config/filesystems.php" file. N.B. You can create multiple "Symbolic Links" between multiple folders/directories by editing the value of the 'link' array key/index in config/filesystem.php file
        $imagePath = request('image')->store('uploads', 'public'); // File Uploads: https://laravel.com/docs/9.x/filesystem#file-uploads
        $image = \Intervention\Image\Facades\Image::make(public_path("/storage/{$imagePath}"))->fit(1200, 1200); // Intervention Image package
        $image->save();

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image'   => $imagePath
        ]);
        // dd(auth()->user());


        return redirect('/profile/' . auth()->user()->id);
    }


    // show a post (the image and its caption) when clicked on in index.blade.php
    public function show(Post $post) { // Route Model Binding: https://laravel.com/docs/9.x/routing#route-model-binding
        // dd($post);


        return view('posts/show', compact('post')); // Or this is exactly the same as:    return view('posts/show', ['post' => $post]);
    }

}