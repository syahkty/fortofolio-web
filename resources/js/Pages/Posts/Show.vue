<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    post: Object,
});

// Format tanggal agar lebih mudah dibaca
const formattedDate = computed(() => {
    return new Date(props.post.published_at).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
});
</script>

<template>
    <Head :title="post.title" />

    <PublicLayout>
        <article class="container mx-auto px-6 py-16 md:py-24 max-w-4xl">
            <img v-if="post.image_url" :src="post.image_url" :alt="post.title" class="w-full h-auto max-h-[500px] object-cover rounded-lg mb-8 shadow-lg">

            <header>
                <h1 class="text-4xl md:text-5xl font-bold text-white leading-tight mb-4 text-center">
                    {{ post.title }}
                </h1>
                <p class="text-center text-slate-400 mb-10">
                    Diterbitkan pada {{ formattedDate }}
                </p>
            </header>

            <div
                v-html="post.body"
                class="prose prose-invert prose-lg max-w-none 
                       prose-p:text-slate-300 prose-headings:text-neon-cyan 
                       prose-a:text-neon-cyan prose-strong:text-white 
                       prose-blockquote:border-neon-cyan prose-blockquote:text-slate-300"
            ></div>

            <div class="mt-16 text-center">
                <Link href="/#blog" class="text-neon-cyan hover:underline">
                    &larr; Kembali ke semua artikel
                </Link>
            </div>
        </article>
    </PublicLayout>
</template>