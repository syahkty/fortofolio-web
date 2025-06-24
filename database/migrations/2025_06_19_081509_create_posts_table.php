<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul artikel blog
            $table->string('slug')->unique(); // URL-friendly untuk artikel
            $table->text('excerpt'); // Cuplikan/ringkasan singkat
            $table->longText('body'); // Isi lengkap artikel
            $table->string('image')->nullable(); // Gambar utama artikel
            $table->timestamp('published_at')->nullable(); // Untuk menjadwalkan atau draft
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};