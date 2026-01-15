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
        Schema::create('family_branches', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name'); // Nama cabang keluarga
            $table->string('founder_name'); // Nama pendiri cabang
            $table->text('description')->nullable(); // Deskripsi cabang
            $table->string('location')->nullable(); // Lokasi geografis utama
            $table->integer('generation')->default(1); // Generasi keberapa dari founder utama
            $table->string('color_code', 7)->default('#3B82F6'); // Warna untuk visualisasi

            // Admin yang bertanggung jawab untuk cabang ini
            $table->uuid('admin_id')->nullable();
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');

            // Metadata
            $table->boolean('is_active')->default(true);
            $table->integer('members_count')->default(0); // Cache counter
            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();

            $table->index('admin_id');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_branches');
    }
};
