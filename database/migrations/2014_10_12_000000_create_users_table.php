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
            Schema::table('users', function (Blueprint $table) {
                $table->string('firstname');
                $table->string('lastname');
                $table->enum('gender',['none','male','female',])->default('none');
                $table->string('username',100)->unique()->index();
                $table->string('email')->nullable();
                $table->timestamp('verified_at')->nullable();
                $table->char('mobile',13)->unique()->index();
                $table->string('password');
                $table->string('address')->nullable();
                $table->string('phone')->nullable();
                $table->char('zipCode',10)->nullable();
                $table->string('api_token', 80)->unique()->nullable();
                $table->softDeletes();
                $table->rememberToken();
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
