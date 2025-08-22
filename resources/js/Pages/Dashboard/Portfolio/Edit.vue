<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PortfolioForm from './Partials/PortfolioForm.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    portfolio: Object,
});

const form = useForm({
    _method: 'PUT', // Penting untuk update dengan file
    title: props.portfolio.title,
    description: props.portfolio.description,
    technologies: props.portfolio.technologies,
    live_url: props.portfolio.live_url,
    source_code_url: props.portfolio.source_code_url,
    // image: null,
});

const submit = () => {
    // Kirim sebagai POST karena form berisi file
    form.post(route('dashboard.portfolios.update', props.portfolio.id));
};
</script>

<template>
    <Head title="Edit Proyek" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight">Edit Proyek: {{ portfolio.title }}</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-glass-bg border border-slate-700 rounded-lg p-6">
                    <form @submit.prevent="submit">
                        <PortfolioForm :form="form" />

                        <div class="mt-4">
                            <p class="text-sm text-slate-400">Gambar Saat Ini:</p>
                            <img v-if="portfolio.image" :src="portfolio.image" class="w-32 h-auto rounded mt-2">
                            <p v-else class="text-sm text-slate-500">Tidak ada gambar.</p>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="submit" :disabled="form.processing" class="bg-neon-cyan text-dark-bg font-bold py-2 px-4 rounded-lg shadow-neon-sm disabled:opacity-50">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>