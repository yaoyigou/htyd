<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->increments('cat_id')->unsigned();
            $table->string('cat_name', 30)->default('')->comment('分类名称');
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
