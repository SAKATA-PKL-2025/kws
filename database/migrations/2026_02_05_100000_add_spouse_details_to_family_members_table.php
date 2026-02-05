<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::table('family_members', function (Blueprint $table) {
      $table->string('spouse_phone')->nullable()->after('spouse_name');
      $table->string('spouse_email')->nullable()->after('spouse_phone');
      $table->string('spouse_occupation')->nullable()->after('spouse_email');
    });
  }

  public function down(): void
  {
    Schema::table('family_members', function (Blueprint $table) {
      $table->dropColumn(['spouse_phone', 'spouse_email', 'spouse_occupation']);
    });
  }
};
