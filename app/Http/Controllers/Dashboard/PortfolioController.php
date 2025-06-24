<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
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

    public function store(Request $request)
    {
        // 1. Validasi diubah: 'image' tidak lagi divalidasi, 'live_url' sekarang wajib
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'technologies' => 'required|string',
            'live_url' => 'required|url', // URL sekarang wajib
            'source_code_url' => 'nullable|url',
        ]);

        // 2. Logika Screenshot Otomatis
        try {
            // Buat nama file yang unik dan path penyimpanannya
            $imageName = 'screenshot-' . Str::random(10) . '.png';
            $imagePath = 'portfolio_images/' . $imageName;
            $fullStoragePath = storage_path('app/public/' . $imagePath);

            // Ambil screenshot dari URL dan simpan ke path yang ditentukan
            Browsershot::url($validated['live_url'])
                ->windowSize(1200, 800) // Atur ukuran jendela browser virtual
                ->waitUntilNetworkIdle() // Tunggu sampai semua resource (gambar, script) selesai dimuat
                ->save($fullStoragePath);

            // Simpan path gambar ke data yang akan dimasukkan ke database
            $validated['image'] = $imagePath;

        } catch (\Exception $e) {
            // Jika gagal mengambil screenshot, redirect kembali dengan error
            // Anda bisa mencatat error ini untuk debugging: Log::error($e->getMessage());
            return back()->withInput()->withErrors(['live_url' => 'Gagal mengambil screenshot dari URL ini. Pastikan URL valid dan dapat diakses.']);
        }

        // 3. Simpan data ke database
        $validated['slug'] = Str::slug($request->title);
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