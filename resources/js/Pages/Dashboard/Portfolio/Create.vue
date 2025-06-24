<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PortfolioForm from './Partials/PortfolioForm.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    title: '',
    description: '',
    technologies: '',
    live_url: '',
    source_code_url: '',
    // image: null,
});

const submit = () => {
    form.post(route('portfolios.store'));
};
</script>

<template>
    <Head title="Tambah Proyek Baru" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight">Tambah Proyek Baru</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-glass-bg border border-slate-700 rounded-lg p-6">
                    <form @submit.prevent="submit">
                        <PortfolioForm v-model="form" />
                        <div class="mt-6 flex justify-end">
                            <button type="submit" :disabled="form.processing" class="bg-neon-cyan text-dark-bg font-bold py-2 px-4 rounded-lg shadow-neon-sm disabled:opacity-50">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>