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
        Schema::create('company_applies', function (Blueprint $table) {
            $table->uuid('id')->comment('主键');
            $table->enum('type', ['company', 'person'])->default('company')->comment('资料类型');
            $table->string("id_number")->comment("企业注册号/身份证号码");
            $table->string("name")->comment("企业名称");
            $table->string("legal")->comment("法人/注册人");
            $table->string("phone")->nullable()->comment("联系电话");
            $table->string("email")->nullable()->comment("联系邮箱");
            $table->string("address")->nullable()->comment("注册地址");
            $table->string("account")->nullable()->comment('登录账号');
            $table->string("password")->nullable()->comment("登录密码");
            $table->tinyInteger('status')->default(0)->comment("申请状态");
            $table->string('reason')->nullable()->comment('申请理由');
            $table->string('remark')->nullable()->comment("备注");
            $table->string('reject')->nullable()->comment('拒绝理由');
            $table->timestamp('success_at')->nullable()->comment('通过时间');
            $table->timestamp('reject_at')->nullable()->comment('拒绝时间');
            $table->timestamps();
            $table->comment("企业账户申请表");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_applies');
    }
};
