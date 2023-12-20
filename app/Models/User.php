<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Profile;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [ // Mass Assignment: only the field names inside the $fillable array can be Mass Assign-ed
        'name',
        'email',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];





    public function profile() {
        return $this->hasOne(Profile::class); // A user has one profile
    }

    public function posts() {
        return $this->hasMany(Post::class)->orderBy('created_at', 'DESC'); // A user has many posts    // sort the query results by the 'created_at' column and 'DESC' ordering (in order for the view (index.blade.php) to be able to show images from latest to earliest order)
    }

    // This method is for the "User Following System" and the Follow/Unfollow Button in index.blade.php    // This is a Many To Many Relationship (belongsToMany() method must be used in both models)    // A user can follow many profiles    // Check the followers() method in Profile.php model
    public function following() { // for the Follow/Unfollow Button in index.blade.php    // for the many-to-many relationship between User and Profile, and the intermediate table / pivot table of 2022_05_31_203732_creates_profile_user_pivot_table
        return $this->belongsToMany(Profile::class);
    }


    // Eloquent Events / Model Events: https://laravel.com/docs/9.x/eloquent#events
    // Whenever a user registers for the first time (a new user row gets inserted in `users` table), fill in the `title` column of the `profiles` table (in the row of the `user_id` of the newly registered user) with the `username`    // Check: https://laravel.com/docs/9.x/eloquent#events
    protected static function boot() { // A Model Event (boot() method gets called when that Model is booting up (this method is called whenever a new user gets created))
        parent::boot(); // override the method
        static::created(function($user) { // created() is an event:  When a new model is saved in the database (a user row is created in the database `users` table) for the first time, the 'creating' and 'created' events will dispatch (gets fired) (and another table i.e. `profiles` table, other than the `users` table) and the `title` column of the `profiles` table gets inserted with the username (This created() event gets fired whenever a new user gets 'created' in the database `users` table)    // Eloquent Events / Model Events: https://laravel.com/docs/9.x/eloquent#events
            $user->profile()->create([  // All columns of the `profiles` table are 'nullable' except for the `user_id`
                'title' => $user->username // a default value for `title` is the `username`, and the rest of the `profiles` table records are `nullable`
            ]);
        });
    }

}
