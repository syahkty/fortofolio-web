<script setup>
import { useEditor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import { watch } from 'vue';

const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    },
});

const emit = defineEmits(['update:modelValue']);

const editor = useEditor({
    content: props.modelValue,
    extensions: [
        StarterKit,
    ],
    onUpdate: ({ editor }) => {
        emit('update:modelValue', editor.getHTML());
    },
    // DIUBAH DI SINI: Menambahkan kelas 'prose'
    editorProps: {
        attributes: {
            class: 'p-4 min-h-[300px] bg-slate-800 border-slate-600 rounded-b-md focus:outline-none prose prose-invert max-w-none prose-p:text-slate-300 prose-headings:text-white',
        },
    },
});

watch(() => props.modelValue, (value) => {
    const isSame = editor.value.getHTML() === value;
    if (isSame) {
        return;
    }
    editor.value.commands.setContent(value, false);
});
</script>

<template>
    <div class="border border-slate-600 rounded-md">
        <div v-if="editor" class="flex items-center flex-wrap gap-2 p-2 bg-slate-800/50 rounded-t-md border-b border-slate-600">
            <button type="button" @click="editor.chain().focus().toggleBold().run()" :class="{ 'is-active': editor.isActive('bold') }" class="toolbar-button">Bold</button>
            <button type="button" @click="editor.chain().focus().toggleItalic().run()" :class="{ 'is-active': editor.isActive('italic') }" class="toolbar-button">Italic</button>
            <button type="button" @click="editor.chain().focus().toggleStrike().run()" :class="{ 'is-active': editor.isActive('strike') }" class="toolbar-button">Strike</button>
            <button type="button" @click="editor.chain().focus().setParagraph().run()" :class="{ 'is-active': editor.isActive('paragraph') }" class="toolbar-button">P</button>
            <button type="button" @click="editor.chain().focus().toggleHeading({ level: 1 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 1 }) }" class="toolbar-button text-xl">H1</button>
            <button type="button" @click="editor.chain().focus().toggleHeading({ level: 2 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 2 }) }" class="toolbar-button text-lg">H2</button>
            <button type="button" @click="editor.chain().focus().toggleBulletList().run()" :class="{ 'is-active': editor.isActive('bulletList') }" class="toolbar-button">List</button>
            <button type="button" @click="editor.chain().focus().toggleBlockquote().run()" :class="{ 'is-active': editor.isActive('blockquote') }" class="toolbar-button">Quote</button>
        </div>
        
        <EditorContent :editor="editor" />
    </div>
</template>

<style scoped>
/* Style khusus untuk komponen ini */
.toolbar-button {
    padding: 4px 8px;
    border-radius: 4px;
    color: #cbd5e1; /* slate-300 */
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s ease-in-out;
}
.toolbar-button:hover {
    background-color: rgba(71, 85, 105, 0.5); /* slate-700/50 */
    color: white;
}
.toolbar-button.is-active {
    background-color: rgba(0, 255, 255, 0.2); /* neon-cyan/20 */
    color: #00ffff; /* neon-cyan */
    box-shadow: 0 0 5px rgba(0, 255, 255, 0.5);
}
</style>