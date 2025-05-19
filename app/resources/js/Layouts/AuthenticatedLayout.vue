<template>
    <div>
        <div class="h-screen bg-[#1e2f23] relative">
            <!-- Page Heading -->
            <header class="bg-[#b39c4d] shadow" v-if="$slots.header">
                <div class="mx-auto max-w-7xl px-4 py-2 sm:px-6 lg:px-8 flex justify-between items-center">
                    <div class="">
                        <img :src="Logo" alt="" class="w-16 rounded-full">
                    </div>
                    <slot name="header" />
                    <div class="">{{ page.props.auth.user.name }} | {{ page.props.auth.user.roles.map((item) => item.name).toString()}}</div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="w-full h-[calc(100%-10.5rem)] overfow-y-hidden">
                <Toast />
                <ConfirmDialog />
                <div class="h-full overflow-y-auto">
                    <slot />
                </div>
            </main>
            <Dock :model="items" :pt="{
                itemContent: 'bg-[#b39c4d] rounded-lg border border-gray-500 p-1'
            }">
                <template #itemicon="{ item }">
                    <div class="p-1 cursor-pointer">
                        <div v-tooltip.top="item.label" :class="item.icon" class="" 
                            @click="visit(item.route, item.method)" style="font-size: 1.5rem; font-weight: 900"></div>
                    </div>
                </template>
            </Dock>
        </div>
    </div>
</template>
<script setup lang="ts">
import { onMounted, ref } from 'vue';
import Logo from '@/assets/rotc.jpg';
import { Dock } from 'primevue';
import { router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import ConfirmDialog from 'primevue/confirmdialog';
import {Toast} from 'primevue';

const page = usePage<any>();

const items = ref<{ label: string, icon: string, route?: any, canSee: boolean, method: 'get' | 'post' }[]>([
    {
        label: 'Dashboard',
        icon: 'bi bi-file-bar-graph',
        route: route('dashboard'),
        method: 'get',
        canSee: true
    },
    {
        label: 'Users',
        icon: 'bi bi-person',
        route: route('users.display'),
        method: 'get',
        canSee: true
    },
    {
        label: 'Cadets',
        icon: 'bi bi-people',
        route: route('cadets.display'),
        method: 'get',
        canSee: true
    },
    {
        label: 'Class Years',
        icon: 'bi bi-flag',
        route: route('classYears.display'),
        method: 'get',
        canSee: true
    },
    {
        label: 'Announcements',
        icon: 'bi bi-info-circle',
        route: route('announcements.display'),
        method: 'get',
        canSee: true
    },
    {
        label: 'Public Announcements',
        icon: 'bi bi-megaphone',
        route: route('announcements.public.display'),
        method: 'get',
        canSee: true
    },
    {
        label: 'Cadet Info',
        icon: 'bi bi-info-circle',
        route: route('cadets.info'),
        method: 'get',
        canSee: true
    },
    {
        label: 'Log out',
        icon: 'bi bi-box-arrow-right',
        route: route('logout'),
        method: 'post',
        canSee: true
    }
])


onMounted(() => {
    if(page.props.auth.user.roles.some((v: any) => v.name === 'admin')) {
        items.value = items.value.filter((item) => {
            return !['Cadets', 'Class Years', 'Announcements', 'Public Announcements', 'Cadet Info'].includes(item.label)
        })
    }

    if(page.props.auth.user.roles.some((v: any) => v.name === 's1-admin')) {
        items.value = items.value.filter((item) => { 
            return ['Cadets', 'Class Years', 'Announcements', 'Log out', 'Dashboard'].includes(item.label)
        })
    }

    if(page.props.auth.user.roles.some((v: any) => v.name === 'cadet')) {
        items.value = items.value.filter((item) => {
            return ['Log out', 'Public Announcements', 'Cadet Info'].includes(item.label)
        })
    }
    
})
function visit(route: 'string', method: 'get' | 'post') {
    router[method](route);
}

</script>