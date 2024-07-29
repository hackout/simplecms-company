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
        Schema::create('company_safes', function (Blueprint $table) {
            $table->id('id')->comment("主键");
            $table->foreignUuid('company_account_id')->constrained('company_accounts')->nullable()->comment("账号ID");
            $table->enum('type', ['mobile', 'email'])->default('mobile')->comment("密保类型");
            $table->string("account")->unique()->comment("登录账号");
            $table->string('code')->nullable()->comment("验证码");
            $table->boolean('is_verified')->default(false)->comment("是否已校验");
            $table->timestamp('verified_at')->nullable()->comment("校验时间");
            $table->timestamp('valid_at')->nullable()->comment("验证码有效期");
            $table->ipAddress('verified_ip')->nullable()->comment("校验时IP");
            $table->string('verified_finger')->nullable()->comment("校验时指纹");
            $table->timestamps();
            $table->comment("企业账号安全信息表");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_safes');
    }
};
