<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_setting', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->string('line_notify_token')->nullable();
            $table->tinyInteger('auto_clock_in')->default(0);
            $table->tinyInteger('auto_clock_out')->default(0);
            $table->double('lat')->default(0)->comment('打卡位置');
            $table->double('lng')->default(0)->comment('打卡位置');
            $table->timestamps();
            $table->primary('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_setting');
    }
}
