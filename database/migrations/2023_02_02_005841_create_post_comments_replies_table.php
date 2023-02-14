<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostCommentsRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_comments_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comment_id')->unsigned();
            $table->integer('status')->default(0);
            $table->string('author');
            $table->string('email');
            $table->text('body');
            $table->timestamps();

            $table->foreign('comment_id')->references('id')->on('post_comments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_comments_replies');
    }
}
