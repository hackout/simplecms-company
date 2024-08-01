<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('company_accounts', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment("主键");
            $table->foreignUuid('company_id')->nullable()->comment("公司ID");
            $table->string("account")->unique()->comment("登录账号");
            $table->string("uid")->unique()->comment("UID");
            $table->string('password')->comment('登录密码');
            $table->string('name')->comment("名称");
            $table->json('roles')->nullable()->comment("权限");
            $table->boolean('is_valid')->default(false)->comment("是否启用");
            $table->boolean('is_founder')->default(false)->comment("是否管理员");
            $table->timestamp('last_login')->nullable()->comment("最后登录时间");
            $table->ipAddress('last_ip')->nullable()->comment("最后访问IP");
            $table->integer('failed_count')->default(0)->comment("失败次数");
            $table->ipAddress('register_ip')->nullable()->comment("注册IP");
            $table->string('register_finger')->nullable()->comment("注册指纹");
            $table->timestamps();
            $table->comment("企业账号信息表");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_accounts');
    }
};
