<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post; // DIUBAH: Menggunakan model Post
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Menampilkan daftar semua post.
     */
    public function index()
    {
        return Inertia::render('Dashboard/Post/Index', [
            // DIUBAH: Nama prop menjadi 'posts' (plural) agar lebih jelas
            'posts' => Post::latest()->get()
        ]);
    }

    /**
     * Menampilkan form untuk membuat post baru.
     */
    public function create()
    {
        return Inertia::render('Dashboard/Post/Create');
    }

    /**
     * Menyimpan post baru ke database.
     */
    public function store(Request $request)
    {
        // DIUBAH: Aturan validasi disesuaikan untuk blog
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string', // Ringkasan singkat
            'body' => 'required|string',    // Isi artikel lengkap
            'image' => 'nullable|image|max:2048', // Gambar bisa kosong (nullable)
        ]);

        if ($request->hasFile('image')) {
            // DIUBAH: Disimpan ke folder 'post_images'
            $path = $request->file('image')->store('post_images', 'public');
            $validated['image'] = $path;
        }

        $validated['slug'] = Str::slug($request->title);
        $validated['published_at'] = now(); // Langsung publish

        // DIUBAH: Membuat data menggunakan model Post
        Post::create($validated);

        // DIUBAH: Redirect ke route 'posts.index' dengan pesan yang sesuai
        return redirect()->route('dashboard.posts.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit post.
     */
    public function edit(Post $post) // DIUBAH: Menggunakan model Post
    {
        return Inertia::render('Dashboard/Post/Edit', [
            'post' => $post,
        ]);
    }

    /**
     * Memperbarui post di database.
     */
    public function update(Request $request, Post $post) // DIUBAH: Menggunakan model Post
    {
        // DIUBAH: Aturan validasi untuk update blog
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'body' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $path = $request->file('image')->store('post_images', 'public');
            $validated['image'] = $path;
        }

        $validated['slug'] = Str::slug($request->title);
        $post->update($validated);

        return redirect()->route('dashboard.posts.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Menghapus post dari database.
     */
    public function destroy(Post $post) // DIUBAH: Menggunakan model Post
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('dashboard.posts.index')->with('success', 'Artikel berhasil dihapus.');
    }
    
    public function show(Post $post)
{
    // Opsi tambahan: Jika Anda ingin memastikan hanya post yang sudah
    // di-publish yang bisa dilihat, Anda bisa menambahkan logika ini.
    // if (is_null($post->published_at)) {
    //     abort(404);
    // }

    return Inertia::render('Posts/Show', [
        'post' => $post
    ]);
}
}