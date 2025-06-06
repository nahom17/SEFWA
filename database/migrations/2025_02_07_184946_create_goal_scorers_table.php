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
        Schema::create('goal_scorers', function (Blueprint $table) {
            $table->id(); // Primary key to allow multiple entries for the same player in a fixture
            $table->foreignId('fixture_id')->constrained()->onDelete('cascade');
            $table->foreignId('player_id')->constrained()->onDelete('cascade');
            $table->foreignId('club_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('goals')->default(0);
            $table->unsignedInteger('assists')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goal_scorers');
    }
};
