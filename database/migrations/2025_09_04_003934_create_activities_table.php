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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Название деятельности');
            $table->foreignId('parent_id')->nullable()->constrained('activities')->onDelete('cascade');
            $table->tinyInteger('level')->default(1)->comment('Уровень вложенности (1-3)');
            $table->timestamps();

            // Индексы
            $table->index('parent_id');
            $table->index('level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
