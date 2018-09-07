<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_books', function (Blueprint $table) {
            //user_id	用户id	int (11)
            $table->integer('user_id')->comment('用户id');
            //book_id	账本id	int (11)
            $table->integer('book_id')->comment('账本id');
            $table->primary(['user_id', 'book_id']);
            //status	状态 1可用 0不可用	tinyint (1)
            $table->tinyInteger('status')->default(1)->comment('状态 1可用 0不可用');
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
        Schema::dropIfExists('user_books');
    }
}
