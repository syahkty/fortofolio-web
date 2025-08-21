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
    // ... (Bagian validasi tetap sama) ...
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'technologies' => 'required|string',
        'live_url' => 'required|url',
        'source_code_url' => 'nullable|url',
    ]);

    // 2. Logika Screenshot diubah menggunakan API ScreenshotOne
    // app/Http/Controllers/Dashboard/PortfolioController.php

// ...

try {
    $apiKey = env('SCREENSHOTONE_API_KEY');
    
    // PERBAIKAN 1: Hapus urlencode() dari sini.
    // Biarkan http_build_query yang menanganinya.
    $targetUrl = $validated['live_url']; 

    // Siapkan parameter untuk ScreenshotOne
    $options = [
        'access_key' => $apiKey,
        'url' => $targetUrl, // Sekarang menggunakan URL yang belum di-encode
        'viewport_width' => 1200,
        'viewport_height' => 800,
        'format' => 'png',
        'delay' => 3,
        // PERBAIKAN 2: Hapus baris 'response_type' => 'body'
    ];

    // Buat URL API dengan parameter
    $apiUrl = "https://api.screenshotone.com/take?" . http_build_query($options);

    // Lakukan panggilan HTTP GET ke API
    $response = Http::get($apiUrl);
    
    if ($response->successful()) {
        $imageName = 'screenshot-' . Str::random(10) . '.png';
        $imagePath = 'portfolio_images/' . $imageName;

        Storage::disk('public')->put($imagePath, $response->body());

        $validated['image'] = $imagePath;
    } else {
        // Jika API gagal, kita bisa lempar exception lagi atau dd() untuk debug
        throw new \Exception('API ScreenshotOne gagal merespons. Status: ' . $response->status());
    }

} catch (\Exception $e) {
    return back()->withInput()->withErrors(['live_url' => 'Gagal mengambil screenshot. Pastikan URL dapat diakses oleh publik.']);
}

// ...

    // 3. Simpan data ke database (Model akan menangani slug)
    $validated['published_at'] = now();
    Portfolio::create($validated);

    return redirect()->route('portfolios.index')->with('success', 'Proyek berhasil ditambahkan.');
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
            'live_url' => 'nullable|url',
            'source_code_url' => 'nullable|url',
            'image' => 'nullable|image|max:2048', // Image tidak wajib diisi saat update
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($portfolio->image) {
                Storage::disk('public')->delete($portfolio->image);
            }
            // Simpan gambar baru
            $path = $request->file('image')->store('portfolio_images', 'public');
            $validated['image'] = $path;
        }

        $validated['slug'] = Str::slug($request->title);
        $portfolio->update($validated);

        return redirect()->route('portfolios.index')->with('success', 'Proyek berhasil diperbarui.');
    }

    public function destroy(Portfolio $portfolio)
    {
        // Hapus gambar dari storage
        if ($portfolio->image) {
            Storage::disk('public')->delete($portfolio->image);
        }

        $portfolio->delete();

        return redirect()->route('portfolios.index')->with('success', 'Proyek berhasil dihapus.');
    }
}