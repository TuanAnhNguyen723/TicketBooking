<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Đặt sau cột 'is_active' cho an toàn nếu daily_capacity đã bị xoá
            $table->unsignedInteger('total_capacity')->nullable()->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('total_capacity');
        });
    }
};


