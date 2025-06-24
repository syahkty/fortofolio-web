<script setup>
import RichTextEditor from '@/Components/RichTextEditor.vue'; // <-- IMPORT EDITOR BARU
import { defineProps, defineEmits } from 'vue';

defineProps({
    modelValue: Object, // Form object from useForm
});

defineEmits(['update:modelValue']);
</script>

<template>
    <div class="grid grid-cols-1 gap-6">
        <div>
            <label for="title" class="block text-sm font-medium text-slate-300">Judul Artikel</label>
            <input v-model="modelValue.title" type="text" id="title" class="mt-1 block w-full bg-slate-800 border-slate-600 rounded-md shadow-sm text-white focus:ring-neon-cyan focus:border-neon-cyan">
            <div v-if="modelValue.errors.title" class="text-red-500 text-sm mt-1">{{ modelValue.errors.title }}</div>
        </div>
        
        <div>
            <label for="excerpt" class="block text-sm font-medium text-slate-300">Ringkasan (Excerpt)</label>
            <textarea v-model="modelValue.excerpt" id="excerpt" rows="3" class="mt-1 block w-full bg-slate-800 border-slate-600 rounded-md shadow-sm text-white focus:ring-neon-cyan focus:border-neon-cyan"></textarea>
            <p class="text-xs text-slate-500 mt-1">Ringkasan singkat ini akan muncul di kartu daftar blog.</p>
            <div v-if="modelValue.errors.excerpt" class="text-red-500 text-sm mt-1">{{ modelValue.errors.excerpt }}</div>
        </div>

        <div>
            <label for="body" class="block text-sm font-medium text-slate-300 mb-1">Isi Artikel</label>
            <RichTextEditor v-model="modelValue.body" />
            <div v-if="modelValue.errors.body" class="text-red-500 text-sm mt-1">{{ modelValue.errors.body }}</div>
        </div>
        
        <div>
            <label for="image" class="block text-sm font-medium text-slate-300">Gambar Utama (Opsional)</label>
            <input @input="modelValue.image = $event.target.files[0]" type="file" id="image" class="mt-1 block w-full text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-neon-cyan/20 file:text-neon-cyan hover:file:bg-neon-cyan/30">
            <progress v-if="modelValue.progress" :value="modelValue.progress.percentage" max="100" class="w-full mt-2">
                {{ modelValue.progress.percentage }}%
            </progress>
            <div v-if="modelValue.errors.image" class="text-red-500 text-sm mt-1">{{ modelValue.errors.image }}</div>
        </div>
    </div>
</template>