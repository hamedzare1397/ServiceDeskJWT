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
        Schema::create('coefficient_news', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\News::class);
            $table->foreignIdFor(\App\Models\Coefficient::class);
            $table->string('coefficient');
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['news_id', 'coefficient_id',]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coefficient_news');
    }
};
