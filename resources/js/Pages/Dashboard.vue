<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-glass-bg border border-slate-700 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-slate-300">
                        Selamat datang kembali, {{ $page.props.auth.user.name }}!
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <Link :href="route('portfolios.index')" class="bg-glass-bg border border-slate-700 rounded-lg p-6 flex flex-col items-center justify-center text-center hover:border-neon-cyan/50 hover:-translate-y-2 transition-all duration-300">
                        <h3 class="text-2xl font-bold text-white">Kelola Portofolio</h3>
                        <p class="mt-2 text-slate-400">Tambah, edit, atau hapus proyek portofolio Anda.</p>
                    </Link>

                    <Link :href="route('posts.index')" class="bg-glass-bg border border-slate-700 rounded-lg p-6 flex flex-col items-center justify-center text-center hover:border-neon-cyan/50 hover:-translate-y-2 transition-all duration-300">
                        <h3 class="text-2xl font-bold text-white">Kelola Blog</h3>
                        <p class="mt-2 text-slate-400">Tulis, publikasikan, dan kelola artikel blog Anda.</p>
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>