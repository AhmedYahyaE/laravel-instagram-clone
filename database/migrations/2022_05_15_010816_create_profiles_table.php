<?php
// We created this class to represent user's information. So, every user in the users table has a profile table which contains information about them.
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
        Schema::create('profiles', function (Blueprint $table) { // create user `profiles` table
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable(); // Add a foreign key to reference the User model and `users` table (every user in the `users` table has a profile in the `profiles` table)    // Pay attention to the foreign key NAMING CONVENTION (`user_id`) to reference the User model and the `id` column in the `users` table    // added by me
            $table->string('title')->nullable(); // such as: instagram.com
            $table->text('description')->nullable(); // such as: We're a global community of millions ...
            $table->string('url')->nullable(); // such as: www.instagram.com
            $table->string('image')->nullable(); // added in later stage
            $table->index('user_id'); // "Database Indexing": for better searchability and quicker queries, we add an index on the foreign key `user_id` because we are going to use this column a lot for searching

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
        Schema::dropIfExists('profiles');
    }
};
