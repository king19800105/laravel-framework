<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerifyCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verify_codes', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->nullable(false)->default(0)->comment('验证码类型，1：注册，2：找回密码，3：用户信息修改');
            $table->string('code', 8)->nullable(false)->default('')->comment('验证码');
            $table->char('mobile', 11)->nullable(false)->default('')->comment('手机号码');
            $table->timestamp('created_at')->useCurrent();
            $table->index(['mobile', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verify_codes');
    }
}
