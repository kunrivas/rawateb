<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rendement_reservation_employees', function (Blueprint $table) {
            $table->text('zero_point_reason')->nullable()->after('point');
        });
    }

    public function down(): void
    {
        Schema::table('rendement_reservation_employees', function (Blueprint $table) {
            $table->dropColumn('zero_point_reason');
        });
    }
};
