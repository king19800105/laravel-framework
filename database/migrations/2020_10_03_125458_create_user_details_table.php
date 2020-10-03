<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable(false)->default(0)->comment('关联用户id');
            $table->string('contact_name', 20)->nullable(false)->default('')->comment('联系人姓名');
            $table->string('qq', 20)->nullable(false)->default('')->comment('QQ');
            $table->string('contact_phone', 30)->nullable(false)->default('')->comment('联系电话');
            $table->string('company', 50)->nullable(false)->default('')->comment('公司名称');
            $table->string('province', 30)->nullable(false)->default('')->comment('所在省');
            $table->string('city', 30)->nullable(false)->default('')->comment('所在市');
            $table->string('district', 30)->nullable(false)->default('')->comment('所在区');
            $table->string('address', 100)->nullable(false)->default('')->comment('详细地址');
            $table->timestamps();
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_details');
    }
}
