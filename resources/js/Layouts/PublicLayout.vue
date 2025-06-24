<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

// Props dari controller Laravel
defineProps({
    laravelVersion: String,
    phpVersion: String,
});
// State untuk menu mobile
const isMobileMenuOpen = ref(false);
</script>

<template>
    <div class="bg-dark-bg text-slate-300 font-poppins">
        
        <div class="absolute top-0 -left-4 w-72 h-72 bg-neon-cyan/20 rounded-full mix-blend-lighten filter blur-3xl opacity-40 animate-blob"></div>
        <div class="absolute top-0 -right-4 w-72 h-72 bg-purple-500/20 rounded-full mix-blend-lighten filter blur-3xl opacity-40 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-500/20 rounded-full mix-blend-lighten filter blur-3xl opacity-40 animate-blob animation-delay-4000"></div>

        <div class="relative z-10">
            <nav class="sticky top-0 z-50 bg-glass-bg/80 backdrop-blur-xl border-b border-neon-cyan/20">
                <div class="container mx-auto px-6 py-4">
                    <div class="flex items-center justify-between">
                        <Link href="/" class="text-2xl font-bold text-white hover:text-neon-cyan transition-colors duration-300">
                            Andi<span class="text-neon-cyan">Syahkty</span>
                        </Link>
                        
                        <div class="hidden md:flex items-center space-x-8">
                             <a href="/#hero" class="hover:text-neon-cyan transition-colors duration-300">Home</a>
                             <a href="/#skills" class="hover:text-neon-cyan transition-colors duration-300">Keahlian</a>
                             <a href="/#portfolio" class="hover:text-neon-cyan transition-colors duration-300">Portofolio</a>
                             <a href="/#blog" class="hover:text-neon-cyan transition-colors duration-300">Blog</a>
                             <a href="/#contact" class="hover:text-neon-cyan transition-colors duration-300">Kontak</a>
                        </div>
                        
                        <div class="hidden md:flex">
                             <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="bg-neon-cyan/10 border border-neon-cyan text-neon-cyan px-4 py-2 rounded-md hover:bg-neon-cyan/20 transition-all duration-300 shadow-neon-sm">
                                Dashboard
                            </Link>
                             <Link v-else :href="route('login')" class="bg-neon-cyan/10 border border-neon-cyan text-neon-cyan px-4 py-2 rounded-md hover:bg-neon-cyan/20 transition-all duration-300 shadow-neon-sm">
                                Login
                            </Link>
                        </div>
                        
                        <div class="md:hidden">
                            <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="text-white focus:outline-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path v-show="!isMobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                                    <path v-show="isMobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <div v-show="isMobileMenuOpen" class="md:hidden mt-4 space-y-2">
                        <a @click="isMobileMenuOpen = false" href="/#hero" class="block py-2 text-center hover:bg-slate-700/50 rounded">Home</a>
                        <a @click="isMobileMenuOpen = false" href="/#skills" class="block py-2 text-center hover:bg-slate-700/50 rounded">Keahlian</a>
                        <a @click="isMobileMenuOpen = false" href="/#portfolio" class="block py-2 text-center hover:bg-slate-700/50 rounded">Portofolio</a>
                        <a @click="isMobileMenuOpen = false" href="/#blog" class="block py-2 text-center hover:bg-slate-700/50 rounded">Blog</a>
                        <a @click="isMobileMenuOpen = false" href="/#contact" class="block py-2 text-center hover:bg-slate-700/50 rounded">Kontak</a>
                    </div>
                </div>
            </nav>

            <main>
                <slot />
            </main>
            
            <footer id="contact" class="bg-glass-bg/80 backdrop-blur-xl border-t border-neon-cyan/20 mt-20">
                <div class="container mx-auto px-6 py-8">
                    <div class="flex flex-col items-center text-center">
                        <h3 class="text-2xl font-bold text-white">Hubungi Saya</h3>
                        <p class="max-w-md mx-auto mt-2 text-slate-400">Tertarik untuk berkolaborasi? Hubungi saya.</p>
                        <a href="mailto: andisyahkty20@gmail.com" class="text-lg text-neon-cyan mt-4 hover:underline">andisyahkty20@gmail.com</a>
                        
                        </div>

                    <div class="mt-8 border-t border-slate-700 w-full pt-6 text-center text-sm text-slate-500">
                        <p>&copy; 2025 AndiSyahkty. Dibuat dengan <span class="text-neon-cyan">&#9829;</span> dan Tailwind CSS.</p>
                        <p class="mt-2">
                            Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</template>