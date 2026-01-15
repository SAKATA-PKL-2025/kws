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
        Schema::create('family_photos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('photo_path');
            $table->uuid('family_branch_id')->nullable();
            $table->foreign('family_branch_id')->references('id')->on('family_branches')->onDelete('set null');
            $table->date('photo_date')->nullable();
            $table->string('location')->nullable();
            $table->uuid('uploaded_by');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('is_public')->default(true);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->uuid('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_photos');
    }
};
