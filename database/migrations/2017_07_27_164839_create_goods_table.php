<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('goods_id')->unsigned();
            $table->string('goods_name', 50)->default('')->comment('商品名称');
            $table->string('goods_sn', 30)->default('')->comment('商品货号');
            $table->string('zjm', 20)->default('')->comment('商品名称助记码');
            $table->smallInteger('brand_id')->default(0)->comment('品牌');
            $table->integer('goods_number')->default(0)->comment('库存');
            $table->string('sccj', 100)->default('')->comment('生产厂家');
            $table->string('spgg', 100)->default('')->comment('规格');
            $table->string('goods_img')->default('')->comment('商品图片');
            $table->tinyInteger('is_promote')->default(0)->comment('是否促销');
            $table->timestamp('promote_start')->comment('促销开始时间');
            $table->timestamp('promote_end')->comment('促销结束时间');
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
