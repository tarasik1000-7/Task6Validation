<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('car_photos', function (Blueprint $table) {
            $table->foreignId('car_id')
                ->after('id')
                ->constrained('cars')
                ->cascadeOnDelete();

            $table->string('path')
                ->after('car_id');
        });
    }

    public function down(): void
    {
        Schema::table('car_photos', function (Blueprint $table) {
            $table->dropForeign(['car_id']);
            $table->dropColumn(['car_id', 'path']);
        });
    }
};