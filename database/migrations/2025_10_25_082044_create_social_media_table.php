<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //membuat table posts
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table -> integer ('user_id');
            $table -> text ('content');
            $table -> string ('image_url')->nullable();
            $table->timestamps();
            $table -> softDeletes();
        });

        //membuat table comments
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table -> integer ('user_id');
            $table -> integer ('post_id');
            $table -> text ('content');
            $table->timestamps();
            $table -> softDeletes();
        });
        //membuat table likes
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table -> integer ('user_id');
            $table -> integer ('post_id');
            $table->timestamps();
            $table -> softDeletes();
        });
        //membuat table messages
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table -> integer (column: 'sender_id');
            $table -> integer (column: 'receiver_id');
            $table-> text('message_content');
            $table->timestamps();
            $table -> softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('likes');
        Schema::dropIfExists('messages');
        
    }
};
