<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

  public function up(): void
{
    Schema::table('terrains', function (Blueprint $table) {
        // On ajoute user_id (nullable d'abord pour ne pas faire planter tes anciens terrains)
        $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
    });
}

public function down(): void
{
    Schema::table('terrains', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');
    });
}
};
