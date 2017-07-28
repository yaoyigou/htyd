<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdPositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_position', function (Blueprint $table) {
            $table->increments('position_id')->unsigned();
            $table->string('position_name', 50)->default('')->comment('广告位名称');
            $table->smallInteger('ad_width')->default(0)->comment('广告宽度');
            $table->smallInteger('ad_height')->default(0)->comment('广告高度');
            $table->string('position_desc')->default('')->comment('广告描述');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
