<template>
    <Head title="Announcements" />
    <div class="h-screen bg-[#1e2f23] relative overflow-hidden">
            <!-- Page Heading -->
            <header class="bg-[#b39c4d] shadow" v-if="$slots.header">
                <div class="mx-auto max-w-7xl px-4 py-2 sm:px-6 lg:px-8 flex justify-between items-center">
                    <slot name="header" />
                    <div class="">
                        <img :src="Logo" alt="" class="w-16 rounded-full">
                    </div>
                </div>
            </header>
        <div class="h-[calc(100%-5rem)]">
            <Toast />
            <slot />
        </div>
    </div>
</template>
<script setup lang="ts">
import Logo from '@/assets/rotc.jpg';
import {Link} from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head } from '@inertiajs/vue3';
import {Toast} from 'primevue';
</script>
