<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            //account_id	账目id	int (11)
            $table->increments('id');
            //book_id	账本id	int (11)
            $table->integer('book_id')->comment('账本id');
            //status	账目状态 1可用 0不可用	tinyint (1)
            $table->tinyInteger('status')->default(1)->comment('状态 1可用 0不可用');
            //tag	账目类型id	int (11)
            $table->integer('tag_id')->comment('账目类型id');
            //amount 总金额
            $table->decimal('amount',8,2)->comment('总金额');
            //note	备注
            $table->text('note')->comment('备注');
            //location	账目产生地点
            $table->string('location')->comment('账目产生地点');
            //timestamp	账目产生时间
            $table->timestamp('timestamp')->comment('账目产生时间');
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
        Schema::dropIfExists('accounts');
    }
}
