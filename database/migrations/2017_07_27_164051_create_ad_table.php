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
            $table->integer('position_id')->default(0)->comment('排序');
            $table->string('ad_name', 50)->default('')->comment('分类名称');
            $table->string('ad_link', 100)->default('')->comment('分类名称');
            $table->string('ad_code')->default('')->comment('分类名称');
            $table->timestamp('start')->comment('开始时间');
            $table->timestamp('end')->comment('结束时间');
            $table->integer('parent_id')->default(0)->comment('父级id');
            $table->integer('sort_order')->default(0)->comment('排序');
            $table->tinyInteger('is_show')->default(0)->comment('是否显示');
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
