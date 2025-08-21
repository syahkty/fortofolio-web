<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-dark-bg font-poppins">
            <nav class="bg-glass-bg/80 backdrop-blur-xl border-b border-neon-cyan/20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')" class="text-2xl font-bold text-white hover:text-neon-cyan transition-colors duration-300">
                                    Dash<span class="text-neon-cyan">board</span>
                                </Link>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <div class="ms-3 relative">
                                <button @click="showingNavigationDropdown = !showingNavigationDropdown" type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-slate-300 hover:text-white focus:outline-none transition ease-in-out duration-150">
                                    {{ $page.props.auth.user.name }}
                                    <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div v-show="showingNavigationDropdown" class="absolute z-50 mt-2 w-48 rounded-md shadow-lg right-0 bg-glass-bg border border-slate-700">
                                    <div class="py-1 rounded-md">
                                        <Link :href="route('home')" class="block w-full px-4 py-2 text-start text-sm leading-5 text-slate-300 hover:bg-slate-700/50 focus:outline-none focus:bg-slate-700 transition duration-150 ease-in-out">Home</Link>
                                        <Link :href="route('dashboard.profile.edit')" class="block w-full px-4 py-2 text-start text-sm leading-5 text-slate-300 hover:bg-slate-700/50 focus:outline-none focus:bg-slate-700 transition duration-150 ease-in-out">Profile</Link>
                                        <Link :href="route('logout')" method="post" as="button" class="block w-full px-4 py-2 text-start text-sm leading-5 text-slate-300 hover:bg-slate-700/50 focus:outline-none focus:bg-slate-700 transition duration-150 ease-in-out">
                                            Log Out
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <header class="bg-glass-bg shadow-neon-sm" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <main>
                <slot />
            </main>
        </div>
    </div>
</template>