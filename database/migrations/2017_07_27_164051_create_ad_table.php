<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateAdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad', function (Blueprint $table) {
            $table->increments('ad_id')->unsigned();
            $table->integer('position_id')->default(0)->comment('广告位置');
            $table->string('ad_name', 50)->default('')->comment('广告名称');
            $table->string('ad_link', 100)->default('')->comment('广告链接');
            $table->string('ad_img')->default('')->comment('广告图片');
            $table->string('ad_bgc', 10)->default('')->comment('广告背景颜色');
            $table->timestamp('start')->comment('开始时间');
            $table->timestamp('end')->comment('结束时间');
            $table->integer('sort_order')->default(0)->comment('排序');
            $table->integer('goods_id')->default(0)->comment('商品id(商品广告时填写)');
            $table->tinyInteger('enabled')->default(0)->comment('是否开启');
            $table->tinyInteger('type')->default(0)->comment('广告类型;0:图片广告,1:文字广告,2:商品广告');
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
