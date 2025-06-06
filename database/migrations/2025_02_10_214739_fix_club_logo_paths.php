<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Club::chunk(200, function ($clubs) {
        foreach ($clubs as $club) {
            $originalPath = $club->logo;
            $filename = pathinfo($originalPath, PATHINFO_BASENAME);
            $sanitized = urldecode($filename);
            $club->logo = 'logos/'.Str::slug(pathinfo($sanitized, PATHINFO_FILENAME)).'.'.pathinfo($sanitized, PATHINFO_EXTENSION);
            $club->save();
        }
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fix_club_logo_paths');
    }
};
