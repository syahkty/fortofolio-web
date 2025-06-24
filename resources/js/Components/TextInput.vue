<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="bg-slate-800 border-slate-600 text-white focus:border-neon-cyan focus:ring-neon-cyan rounded-md shadow-sm"
        v-model="model"
        ref="input"
    />
</template>