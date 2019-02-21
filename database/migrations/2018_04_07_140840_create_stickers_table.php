<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatememesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('meme_url', 64);
            $table->unsignedMediumInteger('like')->comment('喜欢/点赞');
            $table->string('describe', 128)->comment('描述');
            $table->char('is_hidden', 8)->default('F')->comment('是否隐藏');
            $table->unsignedMediumInteger('comment_count');
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
        Schema::dropIfExists('memes');
    }
}
