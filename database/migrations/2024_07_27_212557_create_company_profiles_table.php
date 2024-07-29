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
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('company_id')->constrained('companies')->comment("企业ID");
            $table->string("id_number")->comment("企业注册号/身份证号码");
            $table->string("name")->comment("企业名称");
            $table->string("legal")->comment("法人/注册人");
            $table->string("phone")->nullable()->comment("联系电话");
            $table->string("email")->nullable()->comment("联系邮箱");
            $table->string("address")->comment("注册地址");
            $table->timestamps();
            $table->comment("企业资料表");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_profiles');
    }
};
