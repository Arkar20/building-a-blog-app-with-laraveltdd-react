<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threads', function (Blueprint $table) {
            $table->id();
            $table->string('title',100);
            $table->foreignId('user_id')->constrained();
            $table->foreignId('channel_id')->constrained();
            $table->bigInteger('comments_count')->default(0);
            $table->unsignedBigInteger('best_comment')->nullable()->default(null)->nullOnDelete();
            $table->boolean('lock')->default(false);
            $table->string('slug')->unique();
            $table->string('desc');
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
        Schema::dropIfExists('threads');
    }
}
