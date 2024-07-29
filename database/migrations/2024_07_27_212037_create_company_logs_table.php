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
        Schema::create('company_logs', function (Blueprint $table) {
            $table->id()->comment("主键");
            $table->foreignUuid("company_id")->constrained('companies')->nullable()->comment("公司ID");
            $table->foreignUuid("company_account_id")->nullable()->comment("账号ID");
            $table->ipAddress()->comment("访问IP");
            $table->string("name")->nullable()->comment("操作说明");
            $table->json("user_agent")->nullable()->comment("访问的UserAgent");
            $table->integer("method")->default(0)->comment("访问方式");
            $table->text("url")->nullable()->comment("访问地址");
            $table->json("parameters")->nullable()->comment("访问参数");
            $table->string("route_name")->nullable()->comment("路由别名");
            $table->boolean('status')->default(true)->comment("请求状态");
            $table->timestamps();
            $table->comment("企业账号操作记录表");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_logs');
    }
};
