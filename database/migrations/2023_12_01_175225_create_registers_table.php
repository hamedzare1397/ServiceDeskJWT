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
        Schema::create('registers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\State::class);
            $table->foreignIdFor(\App\Models\Coefficient::class);
            $table->foreignIdFor(\App\Models\News::class);
            $table->string('year_month');
            $table->integer('value');
            $table->foreignIdFor(\App\Models\User::class, 'creator_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registers');
    }
};
