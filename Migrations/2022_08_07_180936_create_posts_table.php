<?php

use App\Enums\PostStatusType;
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
            $table->string('title')->unique();
            $table->longText('content');
            $table->longText('resume')->nullable();
            $table->string('image')->nullable();
            $table->string('banner')->nullable();
            $table->string('slug')->unique();
            
            $table->unsignedBigInteger('post_category_id')->nullable();
            $table->foreign('post_category_id')->references('id')->on('post_categories');

            $table->dateTimeTz('publication_date');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->enum('post_status', PostStatusType::getValues());
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_tags')->nullable();
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
