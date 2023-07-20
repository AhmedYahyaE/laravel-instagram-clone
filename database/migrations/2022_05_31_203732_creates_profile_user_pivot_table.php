<?php
// This is an intermediate/pivot table for the many-to-many relationship between User model and Profile model (for the Follow/Unfollow Button in index.blade.php)

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_user', function (Blueprint $table) { // Intermediate Table / Pivot Table for the "User Following/Unfollowing System"'s Many To Many Relationship between users (User model i.e. `users` table) and profiles (Profile model i.e. `profiles` table)
            $table->id();

            $table->unsignedBigInteger('profile_id');
            $table->unsignedBigInteger('user_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile_user');
    }
};
