<script setup>
// Anak komponen sekarang SANGAT sederhana.
// Ia hanya menerima 'form' sebagai prop.
defineProps({
    form: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div class="grid grid-cols-1 gap-6">
        <div>
            <label for="title" class="block text-sm font-medium text-slate-300">Judul Proyek</label>
            <input v-model="form.title" type="text" id="title" class="mt-1 block w-full bg-slate-800 border-slate-600 rounded-md shadow-sm text-white focus:ring-neon-cyan focus:border-neon-cyan">
            <div v-if="form.errors.title" class="text-red-500 text-sm mt-1">{{ form.errors.title }}</div>
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-slate-300">Deskripsi</label>
            <textarea v-model="form.description" id="description" rows="4" class="mt-1 block w-full bg-slate-800 border-slate-600 rounded-md shadow-sm text-white focus:ring-neon-cyan focus:border-neon-cyan"></textarea>
            <div v-if="form.errors.description" class="text-red-500 text-sm mt-1">{{ form.errors.description }}</div>
        </div>
        <div>
            <label for="technologies" class="block text-sm font-medium text-slate-300">Teknologi (pisahkan dengan koma)</label>
            <input v-model="form.technologies" type="text" id="technologies" class="mt-1 block w-full bg-slate-800 border-slate-600 rounded-md shadow-sm text-white focus:ring-neon-cyan focus:border-neon-cyan">
            <div v-if="form.errors.technologies" class="text-red-500 text-sm mt-1">{{ form.errors.technologies }}</div>
        </div>
        <div>
            <label for="live_url" class="block text-sm font-medium text-slate-300">URL Live Demo</label>
            <input v-model="form.live_url" type="url" id="live_url" class="mt-1 block w-full bg-slate-800 border-slate-600 rounded-md shadow-sm text-white focus:ring-neon-cyan focus:border-neon-cyan">
            <div v-if="form.errors.live_url" class="text-red-500 text-sm mt-1">{{ form.errors.live_url }}</div>
        </div>
        <div>
            <label for="source_code_url" class="block text-sm font-medium text-slate-300">URL Source Code</label>
            <input v-model="form.source_code_url" type="url" id="source_code_url" class="mt-1 block w-full bg-slate-800 border-slate-600 rounded-md shadow-sm text-white focus:ring-neon-cyan focus:border-neon-cyan">
            <div v-if="form.errors.source_code_url" class="text-red-500 text-sm mt-1">{{ form.errors.source_code_url }}</div>
        </div>
    </div>
</template>