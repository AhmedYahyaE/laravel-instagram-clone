<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Profile extends Model
{
    use HasFactory;



    protected $guarded = []; // Disabling Mass Assignment

    public function user() {
        return $this->belongsTo(User::class); // to define the relationshiop between the `profiles` table and its `user_id` foreign key (or the Profile model) and the `users` table (or the User model)    // It's the Inverse Of The Relationship (one-to-one) (a profile belongs to a user)
    }



    public function profileImage() { // return our default/temporary image Or the image uploaded by the user
        $imagePath = $this->image ? $this->image : 'profile/QebY8zPmFZsWjfWl0L1C463ikA9U0anHaHUiSff7.png'; // either the image uploaded by the user or our default/temporay image
        return '/storage/' . $imagePath;
    }


    // This method is for the "User Following System" and the "Follow/Unfollow" Button in index.blade.php
    public function followers() {
        return $this->belongsToMany(User::class); // Defining the relationship: A profile belongs to many FOLLOWERS    // This is a Many To Many Relationship (belongsToMany() method must be used in both models)
    }

}
