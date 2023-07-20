<?php
// We created this table for the posts of a user (one-to-many relationship)

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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id'); // A foreign key to the user `id` in `users` table
            $table->string('caption');
            $table->string('image');
            $table->index('user_id'); // This allows for deleting the posts of a user if the user were to be deleted    // Make the foreign key column (`user_id`) an index (database indexing)

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
        Schema::dropIfExists('posts');
    }
};
