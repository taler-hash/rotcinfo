<template>
    <Head title="Track" />
    <div class="flex min-h-screen flex-col items-center bg-[#1e2f23] pt-6 sm:justify-center sm:pt-0">
        <div>
            <Link href="/">
                <ApplicationLogo class="h-20 w-20 fill-current text-[#b39c4d]" />
            </Link>
        </div>
        <div class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg">
            <Toast />
            <slot />
        </div>
    </div>
</template>
<script setup lang="ts">
import {Link} from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head } from '@inertiajs/vue3';
import {Toast} from 'primevue';
</script>
