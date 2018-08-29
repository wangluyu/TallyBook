<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            //partner_id	参与人id	int (11)
            $table->increments('id')->comment('参与人id');
            //book_id	账本id	int (11)
            $table->integer('book_id')->comment('账本id');
            //partner_name	参与人称呼	varchar (16)
            $table->string('name')->comment('参与人称呼');
            //rate	付款比例	int (2)
            $table->tinyInteger('rate')->default(1)->comment('付款比例');
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
        Schema::dropIfExists('partners');
    }
}
