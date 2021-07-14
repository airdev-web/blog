<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePosts extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->boolean('is_active')->default(false);
            $table->boolean('is_google_index')->default(false);
            $table->string('slug');

            $table->date('publish_date')->nullable();
            $table->string('title');
            $table->text('title_intro')->nullable();
            $table->longText('content')->nullable();

            $table->string('link_intro_title')->nullable();
            $table->string('link_intro_href')->nullable();
            $table->text('banner_title')->nullable();
            $table->text('banner_link')->nullable();

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
