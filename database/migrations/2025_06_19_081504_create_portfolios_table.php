<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul proyek
            $table->string('slug')->unique(); // URL-friendly, misal: "proyek-keren-saya"
            $table->text('description'); // Deskripsi singkat yang tampil di kartu
            $table->string('image'); // Path ke file gambar/screenshot proyek
            $table->string('live_url')->nullable(); // Link ke website live demo
            $table->string('source_code_url')->nullable(); // Link ke GitHub/GitLab
            $table->string('technologies'); // Daftar teknologi, misal: "Laravel, Vue, Tailwind"
            $table->timestamp('published_at')->nullable(); // Untuk menandai apakah sudah dipublish
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};