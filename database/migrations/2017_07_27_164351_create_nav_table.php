<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nav', function (Blueprint $table) {
            $table->smallIncrements('id')->unsigned();
            $table->string('name', 50)->default('')->comment('导航名称');
            $table->tinyInteger('is_show')->default(0)->comment('是否显示');
            $table->tinyInteger('is_open')->default(0)->comment('是否新开');
            $table->tinyInteger('type')->default(0)->comment('导航位置;0:顶部,1:中间,2:底部,后续可以扩展');
            $table->smallInteger('sort_order')->default(0)->comment('排序');
            $table->string('url', 100)->default('')->comment('访问路径');
            $table->string('code', 20)->default('')->comment('通过匹配code检查是否被选中');
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
