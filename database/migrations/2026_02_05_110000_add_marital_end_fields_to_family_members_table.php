<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::table('family_members', function (Blueprint $table) {
      $table->date('marital_end_date')->nullable()->after('marriage_date');
      $table->text('marital_end_note')->nullable()->after('marital_end_date');
    });
  }

  public function down(): void
  {
    Schema::table('family_members', function (Blueprint $table) {
      $table->dropColumn(['marital_end_date', 'marital_end_note']);
    });
  }
};
