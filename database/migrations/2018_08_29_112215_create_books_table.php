<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            //id	账本id	int (11)
            $table->increments('id');
            //book_title	账本名称	varchar (255)
            $table->string('name')->default('喵旅账本');
            //status	状态 1可用 0不可用	tinyint (1)
            $table->tinyInteger('status')->default(1)->comment('状态 1可用 0不可用');
            //end_timestamp	预计结束时间（时间戳）	timestamp
            $table->timestamp('end_timestamp');
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
        Schema::dropIfExists('books');
    }
}
