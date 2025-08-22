<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;

class PortfolioController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard/Portfolio/Index', [
            'portfolios' => Portfolio::latest()->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('Dashboard/Portfolio/Create');
    }

    // app/Http/Controllers/PortfolioController.php
public function store(Request $request)
{
    // Pastikan Anda sudah menghapus semua kode debug dd() dan config([...])
    
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'technologies' => 'required|string',
        'live_url' => 'required|url',
        'source_code_url' => 'nullable|url',
    ]);

    try {
        Configuration::instance([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_KEY'),
                'api_secret' => env('CLOUDINARY_SECRET')
            ],
            'url' => [
                'secure' => true
            ]
        ]);
        $apiKey = env('SCREENSHOTONE_API_KEY');
        $targetUrl = $validated['live_url'];

        $options = [
            'access_key' => $apiKey,
            'url' => $targetUrl,
            'viewport_width' => 1200,
            'viewport_height' => 800,
            'format' => 'png',
            'delay' => 3,
        ];

        $apiUrl = "https://api.screenshotone.com/take?" . http_build_query($options);
        $response = Http::get($apiUrl);

        if ($response->successful()) {
            // 2. Buat objek UploadApi dan panggil method upload
            $uploadApiResponse = (new UploadApi())->upload(
                'data:image/png;base64,' . base64_encode($response->body()),
                [
                    'folder' => 'portfolio_images',
                    'public_id' => 'screenshot-' . Str::slug($validated['title']) . '-' . Str::random(5),
                ]
            );

            // 3. Ambil URL aman dari hasil respons
            $validated['image'] = $uploadApiResponse['secure_url'];

        } else {
            throw new \Exception('API ScreenshotOne gagal merespons. Status: ' . $response->status());
        }

    } catch (\Exception $e) {
        return back()->withInput()->withErrors(['live_url' => 'Gagal mengambil screenshot: ' . $e->getMessage()]);
    }

    $validated['published_at'] = now();
    Portfolio::create($validated);

    return redirect()->route('dashboard.portfolios.index')->with('success', 'Proyek berhasil ditambahkan.');
}



    public function edit(Portfolio $portfolio)
    {
        return Inertia::render('Dashboard/Portfolio/Edit', [
            'portfolio' => $portfolio,
        ]);
    }

    public function update(Request $request, Portfolio $portfolio)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'technologies' => 'required|string',
        'live_url' => 'required|url',
        'source_code_url' => 'nullable|url',
        // Kita tidak lagi memvalidasi 'image' dari form
    ]);

    // Cek apakah URL demo diubah. Jika ya, buat screenshot baru.
    if ($request->live_url !== $portfolio->live_url) {
        try {
            // 1. Panggil API ScreenshotOne
            $apiKey = env('SCREENSHOTONE_API_KEY');
            $targetUrl = $validated['live_url'];
            $options = [
                'access_key' => $apiKey,
                'url' => $targetUrl,
                'viewport_width' => 1200,
                'viewport_height' => 800,
                'format' => 'png',
                'delay' => 3,
            ];
            $apiUrl = "https://api.screenshotone.com/take?" . http_build_query($options);
            $response = Http::get($apiUrl);

            if ($response->successful()) {
                // Hapus gambar lama dari Cloudinary jika ada
                if ($portfolio->image) {
                    // Ekstrak public_id dari URL gambar lama
                    preg_match('/\/v\d+\/(.*)\.\w+$/', $portfolio->image, $matches);
                    if (isset($matches[1])) {
                        (new UploadApi())->destroy($matches[1]);
                    }
                }

                // Upload gambar baru ke Cloudinary
                $uploadApiResponse = (new UploadApi())->upload(
                    'data:image/png;base64,' . base64_encode($response->body()),
                    [
                        'folder' => 'portfolio_images',
                        'public_id' => 'screenshot-' . Str::slug($validated['title']) . '-' . Str::random(5),
                    ]
                );

                // Masukkan URL gambar baru ke data yang akan diupdate
                $validated['image'] = $uploadApiResponse['secure_url'];

            } else {
                throw new \Exception('API ScreenshotOne gagal merespons. Status: ' . $response->status());
            }

        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['live_url' => 'Gagal memperbarui screenshot: ' . $e->getMessage()]);
        }
    }

    // Update data di database
    $portfolio->update($validated);

    return redirect()->route('dashboard.portfolios.index')->with('success', 'Proyek berhasil diperbarui.');
}

    public function destroy(Portfolio $portfolio)
    {
        // Hapus gambar dari storage
        if ($portfolio->image) {
            Storage::disk('public')->delete($portfolio->image);
        }

        $portfolio->delete();

        return redirect()->route('dashboard.portfolios.index')->with('success', 'Proyek berhasil dihapus.');
    }
}