<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            //tag_id	类型id	int (11)
            $table->increments('id');
            //user_id	用户id （0为默认，所有用户均可见）	int (11)
            $table->integer('user_id')->default(0)->comment('用户id （0为默认，所有用户均可见)');
            //tag_name	账目名称（衣食住行玩等）	int (11)
            $table->string('name')->comment('类型名称');
            //tag_parent_id	父id，对应tag_id，0表示一级	int (11)
            $table->integer('pid')->default(0)->comment('父id，对应tag_id，0表示一级	int (11)');
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
        Schema::dropIfExists('tags');
    }
}
