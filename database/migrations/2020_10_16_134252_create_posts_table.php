<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
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
            $table->string('title');
            $table->text('description');
            $table->text('content');
            $table->string('image');
            $table->integer('category_id'); //id for category - category has many posts || post belong to a category
            $table->timestamp('published_at')->nullable();
            //$table->softDeletes(); --> if run migrate:refresh now, all the data in db will be deleted. thats why we create new migration for softdelete. if we want to migrate:refresh again, it will only undo and do the previous migration which is migrate softdelete
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
}
