<script setup>
import { useForm } from '@inertiajs/vue3';
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
    modelValue: Object, // Form object from useForm
});

const emit = defineEmits(['update:modelValue']);

const form = useForm(props.modelValue);
</script>

<template>
    <div class="grid grid-cols-1 gap-6">
        <div>
            <label for="title" class="block text-sm font-medium text-slate-300">Judul Proyek</label>
            <input v-model="modelValue.title" type="text" id="title" class="mt-1 block w-full bg-slate-800 border-slate-600 rounded-md shadow-sm text-white focus:ring-neon-cyan focus:border-neon-cyan">
            <div v-if="modelValue.errors.title" class="text-red-500 text-sm mt-1">{{ modelValue.errors.title }}</div>
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-slate-300">Deskripsi</label>
            <textarea v-model="modelValue.description" id="description" rows="4" class="mt-1 block w-full bg-slate-800 border-slate-600 rounded-md shadow-sm text-white focus:ring-neon-cyan focus:border-neon-cyan"></textarea>
            <div v-if="modelValue.errors.description" class="text-red-500 text-sm mt-1">{{ modelValue.errors.description }}</div>
        </div>
        <div>
            <label for="technologies" class="block text-sm font-medium text-slate-300">Teknologi (pisahkan dengan koma)</label>
            <input v-model="modelValue.technologies" type="text" id="technologies" class="mt-1 block w-full bg-slate-800 border-slate-600 rounded-md shadow-sm text-white focus:ring-neon-cyan focus:border-neon-cyan">
            <div v-if="modelValue.errors.technologies" class="text-red-500 text-sm mt-1">{{ modelValue.errors.technologies }}</div>
        </div>
        <div>
            <label for="live_url" class="block text-sm font-medium text-slate-300">URL Live Demo</label>
            <input v-model="modelValue.live_url" type="url" id="live_url" class="mt-1 block w-full bg-slate-800 border-slate-600 rounded-md shadow-sm text-white focus:ring-neon-cyan focus:border-neon-cyan">
        </div>
        <div>
            <label for="source_code_url" class="block text-sm font-medium text-slate-300">URL Source Code</label>
            <input v-model="modelValue.source_code_url" type="url" id="source_code_url" class="mt-1 block w-full bg-slate-800 border-slate-600 rounded-md shadow-sm text-white focus:ring-neon-cyan focus:border-neon-cyan">
        </div>
        <!-- <div>
            <label for="image" class="block text-sm font-medium text-slate-300">Gambar Proyek</label>
            <input @input="modelValue.image = $event.target.files[0]" type="file" id="image" class="mt-1 block w-full text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-neon-cyan/20 file:text-neon-cyan hover:file:bg-neon-cyan/30">
            <progress v-if="modelValue.progress" :value="modelValue.progress.percentage" max="100" class="w-full mt-2">
                {{ modelValue.progress.percentage }}%
            </progress>
            <div v-if="modelValue.errors.image" class="text-red-500 text-sm mt-1">{{ modelValue.errors.image }}</div>
        </div> -->
    </div>
</template>