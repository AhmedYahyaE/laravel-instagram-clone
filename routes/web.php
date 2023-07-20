<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Scaffold basic "login" and "registration" 'views' and 'routes' as a resutl of running the command: "php artisan ui:auth"
Auth::routes();

// for sending automatic Welcome emails to new registered emails
Route::get('/email', function() {
    return new \App\Mail\NewUserMailWelcome();
});


// A route for the Axios call of the 'Follow/Unfollow' Button in profiles/index.blade.php    // Check resources/js/components/FollowButton.vue
Route::post('follow/{user}', [\App\Http\Controllers\FollowsController::class, 'store']);

// Posts
Route::get('/', [\App\Http\Controllers\PostsController::class, 'index']); // Showing the latest posts from all the profiles a user is "following" in sequential order
Route::get('/p/create', [\App\Http\Controllers\PostsController::class, 'create']); // p stands for post    // this route is for the Add New Post button in home.blade.php to add a new post
Route::get('/p/{post}', [\App\Http\Controllers\PostsController::class, 'show']); // to show a post (the image and its caption) when clicked on in index.blade.php
Route::post('/p', [\App\Http\Controllers\PostsController::class, 'store']); // to Submit data in create.blade.php    // p stands for post

// Profiles
Route::get('/profile/{user}', [App\Http\Controllers\ProfilesController::class, 'index'])->name('profile.show'); // open the profile page index.blade.php
Route::get('/profile/{user}/edit', [App\Http\Controllers\ProfilesController::class, 'edit'])->name('profile.edit'); // Edit Profile (edit.blade.php)
Route::patch('/profile/{user}', [App\Http\Controllers\ProfilesController::class, 'update'])->name('profile.update'); // Edit HTML Form Submission in edit.blade.php