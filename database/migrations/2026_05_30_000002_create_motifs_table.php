<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('motifs', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique();
            $table->enum('category', ['sakral', 'umum', 'sakral_pengantin'])->default('umum');
            $table->text('philosophical_meaning');
            $table->text('history')->nullable();
            $table->text('visual_description')->nullable();
            $table->enum('technique', ['tulis', 'cap', 'combination'])->default('tulis');
            $table->enum('usage_rule', ['umum', 'sakral_pengantin', 'terbatas'])->default('umum');
            $table->string('knowledge_source');
            $table->enum('verification_status', ['terverifikasi', 'terdata', 'perlu_pendalaman'])->default('terdata');
            $table->string('main_image')->nullable();
            $table->string('thumbnail_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('motifs');
    }
};