<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funds', function (Blueprint $table) {
            //fund_id	款项id
            $table->increments('id');
            //book_id	账本id
            $table->integer('book_id')->comment('账本id');
            //account_id	账目id
            $table->integer('account_id')->comment('账目id');
            //total_amount	总金额
            $table->decimal('total_amount',8,2)->comment('总金额');
            //paid_amount	已结金额（待定）
            $table->decimal('paid_amount',8,2)->comment('已结金额（待定）');
            //type	1 应付 2 应收
            $table->tinyInteger('type')->comment('1 应付 2 应收');
            //partner_id	款项所属人id
            $table->integer('partner_id')->comment('款项所属人id');
            //status	款项状态 1已结清 0 未结 2 未结完
            $table->tinyInteger('status')->default(0)->comment('款项状态 1已结清 0 未结 2 未结完');
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
        Schema::dropIfExists('funds');
    }
}
