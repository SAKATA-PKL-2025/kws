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
        Schema::create('family_members', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Informasi Dasar
            $table->string('full_name');
            $table->string('nickname')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->date('death_date')->nullable();
            $table->string('death_place')->nullable();
            $table->boolean('is_alive')->default(true);

            // Relasi Keluarga
            $table->uuid('family_branch_id')->nullable();
            $table->foreign('family_branch_id')->references('id')->on('family_branches')->onDelete('set null');

            $table->uuid('father_id')->nullable();
            $table->foreign('father_id')->references('id')->on('family_members')->onDelete('set null');

            $table->uuid('mother_id')->nullable();
            $table->foreign('mother_id')->references('id')->on('family_members')->onDelete('set null');

            $table->uuid('spouse_id')->nullable(); // Pasangan utama
            $table->foreign('spouse_id')->references('id')->on('family_members')->onDelete('set null');

            $table->integer('generation')->default(1); // Generasi keberapa
            $table->integer('child_order')->nullable(); // Urutan anak ke berapa

            // Status Pernikahan
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->default('single');
            $table->date('marriage_date')->nullable();

            // Informasi Tambahan
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('occupation')->nullable(); // Pekerjaan
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('country')->default('Indonesia');

            // Foto & Media
            $table->string('profile_photo')->nullable();
            $table->text('biography')->nullable(); // Cerita singkat

            // Approval System
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->uuid('submitted_by')->nullable(); // Admin Keluarga yang submit
            $table->foreign('submitted_by')->references('id')->on('users')->onDelete('set null');
            $table->uuid('approved_by')->nullable(); // Super Admin yang approve
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();

            // Metadata
            $table->boolean('is_public')->default(true); // Apakah ditampilkan di public view
            $table->boolean('is_founder')->default(false); // Apakah founder keluarga
            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();

            // Indexes untuk performance
            $table->index('family_branch_id');
            $table->index('father_id');
            $table->index('mother_id');
            $table->index('status');
            $table->index('generation');
            $table->index('is_public');
            $table->index(['full_name', 'birth_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};
