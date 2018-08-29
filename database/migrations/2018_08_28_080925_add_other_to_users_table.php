<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOtherToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('open_id',255)->nullable()->comment('微信open_id');
            $table->string('avatar',255)->nullable()->comment('用户头像，最后一个数值代表正方形头像大小（有0、46、64、96、132数值可选，0代表132*132正方形头像）');
            $table->tinyInteger('gender')->nullable()->comment('用户的性别，值为1时是男性，值为2时是女性，值为0时是未知');
            $table->string('city',30)->nullable()->comment('用户所在城市');
            $table->string('province',30)->nullable()->comment('用户所在省份');
            $table->string('country',30)->nullable()->comment('用户所在国家');
            $table->string('language',10)->nullable()->comment('用户的语言，简体中文为zh_CN');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('open_id')->nullable()->comment('微信open_id');
            $table->string('avatar')->nullable()->comment('用户头像，最后一个数值代表正方形头像大小（有0、46、64、96、132数值可选，0代表132*132正方形头像）');
            $table->string('gender')->nullable()->comment('用户的性别，值为1时是男性，值为2时是女性，值为0时是未知');
            $table->string('city')->nullable()->comment('用户所在城市');
            $table->string('province')->nullable()->comment('用户所在省份');
            $table->string('country')->nullable()->comment('用户所在国家');
            $table->string('language')->nullable()->comment('用户的语言，简体中文为zh_CN');
        });
    }
}
