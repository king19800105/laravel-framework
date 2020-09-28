<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateAdminsTable
 */
class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name')->nullable(false)->default('')->comment('用户名');
            $table->string('mobile')->unique()->nullable(false)->default('')->comment('手机号码');
            $table->string('password')->nullable(false)->default('')->comment('管理员密码');
            $table->softDeletes();
            $table->timestamps();
            $table->unique('mobile');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
