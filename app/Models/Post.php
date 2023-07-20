<?php
// This is a class for a user's posts (`posts` table)
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;



    protected $guarded = []; // Avoid Mass Assignment error (we already validate HTML Form submitted data)


    public function user() {
        return $this->belongsTo(User::class); // A post belongs to a user
    }

}
