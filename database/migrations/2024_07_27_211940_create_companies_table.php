<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->uuid('id')->comment('主键');
            $table->foreignUuid('company_apply_id')->nullable()->comment('注册申请表ID');
            $table->string('name')->comment('名称');
            $table->string("uid")->unique()->comment("暴露UID");
            $table->tinyInteger('status')->default(0)->comment("状态");
            $table->enum('type', ['company', 'person'])->default('company')->comment('资料类型');
            $table->boolean('is_valid')->default(true)->comment('是否有效');
            $table->string("introduction")->nullable()->comment("介绍说明");
            $table->tinyInteger('level')->default(0)->comment("企业等级");
            $table->string("business")->nullable()->comment("商务信息");
            $table->string("remark")->nullable()->comment("备注");
            $table->timestamp('success_at')->nullable()->comment('通过时间');
            $table->timestamp('reject_at')->nullable()->comment('拒绝时间');
            $table->timestamps();
            $table->comment("企业信息表");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
