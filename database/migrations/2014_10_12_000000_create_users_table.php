<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id')->unsigned();
            $table->string('user_name', 50)->comment('会员名称');
            $table->string('email', 50)->comment('邮件');
            $table->string('password', 120)->comment('密码');
            $table->decimal('user_money')->default(0)->comment('会员可用资金');
            $table->decimal('frozen_money')->default(0)->comment('会员冻结资金');
            $table->decimal('pay_points')->default(0)->comment('可兑换积分');
            $table->decimal('rank_points')->default(0)->comment('等级积分');
            $table->decimal('jp_points')->default(0)->comment('精品积分');
            $table->unsignedInteger('address_id')->default(0)->comment('默认收货地址');
            $table->unsignedSmallInteger('user_rank')->default(0)->comment('会员等级');
            $table->unsignedSmallInteger('country')->default(0)->comment('国家');
            $table->unsignedSmallInteger('province')->default(0)->comment('省');
            $table->unsignedSmallInteger('city')->default(0)->comment('市');
            $table->unsignedSmallInteger('district')->default(0)->comment('区');
            $table->unsignedTinyInteger('ls_review')->default(0)->comment('是否审核；0：未审核，1：审核');
            $table->timestamp('last_time')->nullable()->comment('上次登录时间');
            $table->string('last_ip', 15)->default('')->comment('上次登录ip');
            $table->string('msn', 100)->default('')->comment('企业名称');
            $table->string('qq', 20)->default('')->comment('qq');
            $table->string('mobile_phone', 20)->default('')->comment('电话');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
