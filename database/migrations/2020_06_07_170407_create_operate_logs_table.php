<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operate_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('uid')->nullable(false)->default(0);
            $table->string('api')->nullable(false)->default('');
            $table->string('module', 50)->nullable(false)->default('');
            $table->string('exec', 20)->nullable(false)->default('');
            $table->char('ip', 15)->nullable(false)->default('');
            $table->text('params')->nullable(true);
            $table->timestamp('operated_at');
            $table->timestamp('created_at')->useCurrent();
            $table->index('uid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operate_logs');
    }
}
