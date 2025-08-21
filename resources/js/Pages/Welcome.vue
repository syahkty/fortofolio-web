<script setup>
import PublicLayout from "@/Layouts/PublicLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue"; // <--- PASTIKAN 'ref' DI-IMPORT DARI VUE

// Props dari controller Laravel
defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    portfolios: Array,
    posts: Array,
});

// VVVV TAMBAHKAN KODE DI BAWAH INI VVVV

// 1. Buat state untuk melacak kondisi lampu. true = nyala (default).
const isNeonOn = ref(true);

// 2. Buat fungsi untuk mengubah kondisi lampu (on/off)
function toggleNeon() {
    isNeonOn.value = !isNeonOn.value;
}
</script>

<template>
    <Head title="Portofolio Modern Saya" />
    <PublicLayout>
        <main class="container mx-auto px-6">
            <section id="hero" class="min-h-screen flex items-center relative">
                <button
                    @click="toggleNeon"
                    class="absolute top-7 right-8 z-20 key-3d"
                    title="Nyalakan/Matikan Lampu Neon"
                >
                    <svg
                        v-if="isNeonOn"
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                    >
                        <path
                            d="M12 2a10 10 0 0110 10c0 4.25-2.667 7.857-6.322 9.312-.132.044-.282.028-.39-.04a.334.334 0 01-.06-.395c.231-.79.43-2.02.43-2.877 0-1.185-.5-2.622-1.89-2.622-1.789 0-2.491 1.26-2.491 2.622 0 .857.199 2.087.43 2.877.02.068.016.142-.014.205a.332.332 0 01-.39.231c-3.655-1.455-6.322-5.062-6.322-9.312A10 10 0 0112 2zm0 2a8 8 0 100 16 8 8 0 000-16zm0 3a1 1 0 011 1v4a1 1 0 11-2 0V8a1 1 0 011-1z"
                        />
                    </svg>
                    <svg
                        v-else
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 text-slate-500"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 2a10 10 0 0110 10c0 4.25-2.667 7.857-6.322 9.312-.132.044-.282.028-.39-.04a.334.334 0 01-.06-.395c.231-.79.43-2.02.43-2.877 0-1.185-.5-2.622-1.89-2.622-1.789 0-2.491 1.26-2.491 2.622 0 .857.199 2.087.43 2.877.02.068.016.142-.014.205a.332.332 0 01-.39.231c-3.655-1.455-6.322-5.062-6.322-9.312A10 10 0 0112 2zm0 2a8 8 0 100 16 8 8 0 000-16zm0 3a1 1 0 011 1v4a1 1 0 11-2 0V8a1 1 0 011-1z"
                        />
                    </svg>
                </button>

                <div class="text-center md:text-left max-w-3xl">
                    <h1
                        class="text-4xl md:text-6xl font-bold leading-tight transition-all duration-500"
                        :class="{
                            'neon-text neon-flicker': isNeonOn,
                            'text-white': !isNeonOn,
                        }"
                    >
                        Creative <span>Web Developer</span>
                    </h1>

                    <p class="mt-6 text-lg md:text-xl text-slate-400">
                        Saya mengubah ide-ide kompleks menjadi antarmuka web
                        yang indah, fungsional, dan modern. Selamat datang di
                        dunia digital saya.
                    </p>
                    <div
                        class="mt-8 flex justify-center md:justify-start space-x-4"
                    >
                        <a
                            href="#portfolio"
                            class="bg-neon-cyan text-dark-bg font-bold py-3 px-8 rounded-lg shadow-neon hover:scale-105 transition-transform duration-300"
                        >
                            Lihat Portofolio
                        </a>
                        <a
                            href="#contact"
                            class="bg-glass-bg border border-slate-600 py-3 px-8 rounded-lg hover:border-neon-cyan hover:text-neon-cyan transition-colors duration-300"
                        >
                            Hubungi Saya
                        </a>
                    </div>
                </div>
            </section>
            <section id="skills" class="py-20">
                <h2
                    class="text-3xl font-bold text-center text-white mb-2"
                    :class="{
                            'neon-text': isNeonOn,
                            'text-white': !isNeonOn,
                        }"
                >
                    Keahlian Saya
                </h2>
                <div
                    class="w-24 h-1 bg-neon-cyan mx-auto rounded-full mb-12 shadow-neon-sm"
                ></div>
                <div
                    class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6"
                >
                    <div
                        class="bg-glass-bg border border-slate-700 rounded-lg p-6 flex flex-col items-center justify-center text-center hover:border-neon-cyan/50 hover:-translate-y-2 transition-all duration-300"
                    >
                        <img
                            src="https://www.svgrepo.com/show/452228/html-5.svg"
                            alt="HTML5"
                            class="h-16 w-16 mb-4"
                        />
                        <h3 class="font-semibold text-white">HTML5</h3>
                    </div>
                    <div
                        class="bg-glass-bg border border-slate-700 rounded-lg p-6 flex flex-col items-center justify-center text-center hover:border-neon-cyan/50 hover:-translate-y-2 transition-all duration-300"
                    >
                        <img
                            src="https://www.svgrepo.com/show/452185/css-3.svg"
                            alt="CSS3"
                            class="h-16 w-16 mb-4"
                        />
                        <h3 class="font-semibold text-white">CSS3</h3>
                    </div>
                    <div
                        class="bg-glass-bg border border-slate-700 rounded-lg p-6 flex flex-col items-center justify-center text-center hover:border-neon-cyan/50 hover:-translate-y-2 transition-all duration-300"
                    >
                        <img
                            src="https://www.svgrepo.com/show/353925/javascript.svg"
                            alt="JavaScript"
                            class="h-16 w-16 mb-4"
                        />
                        <h3 class="font-semibold text-white">JavaScript</h3>
                    </div>
                    <div
                        class="bg-glass-bg border border-slate-700 rounded-lg p-6 flex flex-col items-center justify-center text-center hover:border-neon-cyan/50 hover:-translate-y-2 transition-all duration-300"
                    >
                        <!-- <img src="https://www.svgrepo.com/show/473788/tailwind-css-icon.svg" > -->
                        <svg
                            fill="#16d7fe"
                            viewBox="0 0 24 24"
                            alt="Tailwind CSS"
                            class="h-16 w-16 mb-4"
                            xmlns="http://www.w3.org/2000/svg"
                            xml:space="preserve"
                            stroke="#16d7fe"
                        >
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g
                                id="SVGRepo_tracerCarrier"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            ></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M12 6.036c-2.667 0-4.333 1.325-5 3.976 1-1.325 2.167-1.822 3.5-1.491.761.189 1.305.738 1.906 1.345C13.387 10.855 14.522 12 17 12c2.667 0 4.333-1.325 5-3.976-1 1.325-2.166 1.822-3.5 1.491-.761-.189-1.305-.738-1.907-1.345-.98-.99-2.114-2.134-4.593-2.134zM7 12c-2.667 0-4.333 1.325-5 3.976 1-1.326 2.167-1.822 3.5-1.491.761.189 1.305.738 1.907 1.345.98.989 2.115 2.134 4.594 2.134 2.667 0 4.333-1.325 5-3.976-1 1.325-2.167 1.822-3.5 1.491-.761-.189-1.305-.738-1.906-1.345C10.613 13.145 9.478 12 7 12z"
                                ></path>
                            </g>
                        </svg>
                        <h3 class="font-semibold text-white">Tailwind CSS</h3>
                    </div>
                    <div
                        class="bg-glass-bg border border-slate-700 rounded-lg p-6 flex flex-col items-center justify-center text-center hover:border-neon-cyan/50 hover:-translate-y-2 transition-all duration-300"
                    >
                        <img
                            src="https://www.svgrepo.com/show/354259/react.svg"
                            alt="React"
                            class="h-16 w-16 mb-4"
                        />
                        <h3 class="font-semibold text-white">React.js</h3>
                    </div>
                    <div
                        class="bg-glass-bg border border-slate-700 rounded-lg p-6 flex flex-col items-center justify-center text-center hover:border-neon-cyan/50 hover:-translate-y-2 transition-all duration-300"
                    >
                        <img
                            src="https://www.svgrepo.com/show/452075/node-js.svg"
                            alt="Node.js"
                            class="h-16 w-16 mb-4"
                        />
                        <h3 class="font-semibold text-white">Node.js</h3>
                    </div>
                </div>
            </section>
            <section id="portfolio" class="py-20">
                <h2
                    class="text-3xl font-bold text-center text-white mb-2"
                    :class="{
                            'neon-text': isNeonOn,
                            'text-white': !isNeonOn,
                        }"
                >
                    Portofolio
                </h2>
                <div
                    class="w-24 h-1 bg-neon-cyan mx-auto rounded-full mb-12 shadow-neon-sm"
                ></div>

                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <div
                        v-for="item in portfolios"
                        :key="item.id"
                        class="bg-glass-bg border border-slate-700 rounded-lg overflow-hidden group"
                    >
                        <img
                            :src="item.image_url"
                            :alt="item.title"
                            class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                        />
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-white mb-2">
                                {{ item.title }}
                            </h3>
                            <p class="text-slate-400 mb-4">
                                {{ item.description }}
                            </p>
                            <div class="flex space-x-4">
                                <a
                                    v-if="item.live_url"
                                    :href="item.live_url"
                                    target="_blank"
                                    class="text-neon-cyan hover:underline"
                                    >Live Demo</a
                                >
                                <a
                                    v-if="item.source_code_url"
                                    :href="item.source_code_url"
                                    target="_blank"
                                    class="text-neon-cyan hover:underline"
                                    >Source Code</a
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section id="blog" class="py-20">
                <h2
                    class="text-3xl font-bold text-center text-white mb-2"
                    :class="{
                            'neon-text': isNeonOn,
                            'text-white': !isNeonOn,
                        }"
                >
                    Tulisan Terbaru
                </h2>
                <div
                    class="w-24 h-1 bg-neon-cyan mx-auto rounded-full mb-12 shadow-neon-sm"
                ></div>

                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <div
                        v-for="post in posts"
                        :key="post.id"
                        class="bg-glass-bg border border-slate-700 rounded-lg overflow-hidden group"
                    >
                        <img
                            v-if="post.image_url"
                            :src="post.image_url"
                            :alt="post.title"
                            class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                        />
                        <div class="p-6">
                            <p class="text-sm text-slate-400 mb-2">
                                {{
                                    new Date(
                                        post.published_at
                                    ).toLocaleDateString("id-ID", {
                                        year: "numeric",
                                        month: "long",
                                        day: "numeric",
                                    })
                                }}
                            </p>
                            <h3 class="text-xl font-bold text-white mb-2">
                                {{ post.title }}
                            </h3>
                            <p class="text-slate-400 mb-4">
                                {{ post.excerpt }}
                            </p>
                            <Link
                                :href="route('posts.show', post.slug)"
                                class="font-semibold text-neon-cyan hover:underline"
                                >Baca Selengkapnya &rarr;</Link
                            >
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </PublicLayout>
</template>
