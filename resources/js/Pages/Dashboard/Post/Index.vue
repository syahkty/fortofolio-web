<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps({
    posts: Array,
});

const successMessage = computed(() => usePage().props.flash?.success);
</script>

<template>
    <Head title="Kelola Blog" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-white leading-tight">Kelola Artikel Blog</h2>
                <Link :href="route('dashboard.posts.create')" class="bg-neon-cyan text-dark-bg font-bold py-2 px-4 rounded-lg shadow-neon-sm hover:scale-105 transition-transform">
                    Tulis Artikel Baru
                </Link>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="successMessage" class="bg-green-500/30 border border-green-500 text-green-300 px-4 py-3 rounded relative mb-4" role="alert">
                    {{ successMessage }}
                </div>
                <div class="bg-glass-bg border border-slate-700 rounded-lg overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-700">
                        <thead class="bg-slate-800/50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Judul</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Gambar</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-300 uppercase tracking-wider">Tanggal Terbit</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-slate-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            <tr v-for="post in posts" :key="post.id">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">{{ post.title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                                    <img v-if="post.image_url" :src="post.image_url" :alt="post.title" class="w-16 h-10 object-cover rounded">
                                    <span v-else>-</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                                    {{ new Date(post.published_at).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' }) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <Link :href="route('dashboard.posts.edit', post.slug)" class="text-indigo-400 hover:text-indigo-300 mr-4">Edit</Link>
                                    <Link :href="route('dashboard.posts.destroy', post.slug)" method="delete" as="button" type="button" class="text-red-500 hover:text-red-400" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">Hapus</Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>