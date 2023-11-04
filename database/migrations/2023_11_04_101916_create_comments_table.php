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
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('post_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('user_name');
            $table->string('user_email');
            $table->string('url')->nullable();
            $table->string('body', 1500);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
