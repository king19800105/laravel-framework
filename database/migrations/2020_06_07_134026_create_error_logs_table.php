<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErrorLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('error_logs', function (Blueprint $table) {
            $table->id();
            $table->text('message')->nullable(true);
            $table->integer('uid')->nullable(false)->default(0);
            $table->string('channel', 30)->nullable(false)->default('');
            $table->char('ip', 15)->nullable(false)->default('');
            $table->string('breakpoint', 50)->nullable(false)->default('');
            $table->string('api')->nullable(false)->default('');
            $table->text('params')->nullable(true);
            $table->timestamp('request_at');
            $table->timestamp('created_at')->useCurrent();
            $table->index(['breakpoint', 'created_at']);
            $table->index('api');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('error_logs');
    }
}
