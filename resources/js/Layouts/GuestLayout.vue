<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col justify-center items-center bg-dark-bg font-poppins text-slate-300 p-4">
        <div class="absolute top-0 -left-4 w-72 h-72 bg-neon-cyan/20 rounded-full mix-blend-lighten filter blur-3xl opacity-40 animate-blob"></div>
        <div class="absolute bottom-0 -right-4 w-72 h-72 bg-purple-500/20 rounded-full mix-blend-lighten filter blur-3xl opacity-40 animate-blob animation-delay-2000"></div>

        <div class="relative z-10">
            <div>
                <Link href="/" class="text-4xl font-bold text-white hover:text-neon-cyan transition-colors duration-300">
                    My<span class="text-neon-cyan">Website</span>
                </Link>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-glass-bg/80 backdrop-blur-xl border border-slate-700 shadow-md overflow-hidden sm:rounded-lg">
                <slot />
            </div>
        </div>
    </div>
</template>