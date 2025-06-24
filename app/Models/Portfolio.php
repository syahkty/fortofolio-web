<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Portfolio extends Model
{
    use HasFactory;

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

    // VVVV TAMBAHKAN PROPERTI INI VVVV
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['image_url'];


    // Accessor Anda yang sudah ada di sini
    public function getImageUrlAttribute()
    {
        // Pengecekan tambahan untuk memastikan $this->image tidak null
        if ($this->image) {
            return Storage::url($this->image);
        }
        return null; // Kembalikan null jika tidak ada gambar
    }
}