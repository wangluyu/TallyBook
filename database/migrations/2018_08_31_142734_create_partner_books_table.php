<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnerBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_books', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('book_id')->comment('账本id');
            $table->integer('partner_id')->comment('参与人id');
            //status	参与人状态 1可用 0 不可用	tinyint (1)
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
        Schema::dropIfExists('partner_books');
    }
}
