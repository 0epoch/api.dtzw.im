<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name', 64);
            $table->string('describe', 120);
            $table->char('is_private', 8)->default('F')->comment('是否仅自己可见');
            $table->unsignedMediumInteger('followers')->comment('关注者');
            $table->unsignedMediumInteger('follow_count')->comment('关注人数');
            $table->unsignedMediumInteger('sticker_count')->comment('表情图数量');
            $table->char('is_block', 8)->default('F')->comment('是否删除');
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
        Schema::dropIfExists('favorites');
    }
}
