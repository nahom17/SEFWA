<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Livewire\after;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('fixtures', function (Blueprint $table) {
            $table->integer('home_score')->default(0);
            $table->integer('away_score')->default(0);
            $table->boolean('is_completed')->default(false);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fixtures', function (Blueprint $table) {
            $table->dropColumn('is_completed');
        });
    }
};
