<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // <-- PASTIKAN INI DI-IMPORT

class Portfolio extends Model
{
    use HasFactory;

    // Bagian $fillable Anda sudah benar
    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'live_url',
        'source_code_url',
        'technologies',
        'published_at',
    ];

    // Bagian $appends Anda sudah benar
    protected $appends = ['image_url'];

    // VVVV INI BAGIAN SLUG OTOMATIS YANG HILANG VVVV
    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Event ini akan berjalan otomatis SETIAP KALI data baru akan dibuat
        static::creating(function ($portfolio) {
            if (empty($portfolio->slug)) {
                $portfolio->slug = self::createSlug($portfolio->title);
            }
        });
    }

    /**
     * Membuat slug yang unik untuk memastikan tidak ada duplikat.
     */
    private static function createSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (static::whereSlug($slug)->exists()) {
            $slug = "{$originalSlug}-" . $count++;
        }

        return $slug;
    }
    // ^^^^ AKHIR DARI BAGIAN SLUG OTOMATIS ^^^^


    // Accessor image_url Anda sudah benar
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return Storage::url($this->image);
        }
        return null;
    }
}