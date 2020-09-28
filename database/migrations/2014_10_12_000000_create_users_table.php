<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name', 20)->nullable(false)->default('')->comment('用户昵称');
            $table->string('wx_open_id', 50)->nullable(false)->default('');
            $table->string('wx_union_id', 50)->nullable(false)->default('');
            $table->char('mobile', 11)->nullable(false)->default('')->comment('手机号');
            $table->string('email', 50)->nullable(false)->default('')->comment('邮箱地址，密码找回时凭证');
            $table->string('password')->nullable(false)->default('')->comment('用户密码');
            $table->tinyInteger('status')->nullable(false)->default(0)->comment('用户状态');
            $table->softDeletes();
            $table->timestamps();
            $table->unique('mobile');
            $table->index('wx_open_id');
            $table->index('wx_union_id');
            $table->index('email');
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
