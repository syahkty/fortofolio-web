<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PostForm from './Partials/PostForm.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    post: Object,
});

const form = useForm({
    _method: 'PUT',
    title: props.post.title,
    excerpt: props.post.excerpt,
    body: props.post.body,
    image: null, // Selalu null saat awal, user harus memilih file baru jika ingin ganti
});

const submit = () => {
    form.post(route('dashboard.posts.update', props.post.slug));
};
</script>

<template>
    <Head title="Edit Artikel" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight">Edit Artikel: {{ post.title }}</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-glass-bg border border-slate-700 rounded-lg p-6">
                    <form @submit.prevent="submit">
                        <PostForm v-model="form" />
                        <div v-if="post.image_url" class="mt-4">
                            <p class="text-sm text-slate-400">Gambar Saat Ini:</p>
                            <img :src="post.image_url" class="w-48 h-auto rounded mt-2">
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="submit" :disabled="form.processing" class="bg-neon-cyan text-dark-bg font-bold py-2 px-4 rounded-lg shadow-neon-sm disabled:opacity-50">
                                Update Artikel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>