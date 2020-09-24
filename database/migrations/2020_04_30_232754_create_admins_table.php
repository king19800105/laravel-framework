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
            $table->string('wx_open_id', 50)->nullable(false)->default('');
            $table->string('wx_union_id', 50)->nullable(false)->default('');
            $table->string('password')->nullable(false)->default('')->comment('管理员密码');
            $table->char('last_logged_ip', 15)->default('');
            $table->timestamp('logged_at');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
            $table->index('wx_open_id');
            $table->index('wx_union_id');
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
