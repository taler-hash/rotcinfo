<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                   
                >
                    <div class="w-full grid lg:grid-cols-2 gap-6">
                        <div v-for="card in cards" class="bg-white w-full rounded-lg px-4 py-4 flex justify-between font-bold">
                            <div :class="card.icon"></div>
                            
                            <p class="text-5xl">{{ card.count }}</p>
                            <p>{{ card.label }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { onMounted, ref } from 'vue'
import { usePage } from '@inertiajs/vue3';

const page = usePage()
const cards = ref<any>([])

onMounted(async () => {
    let _cards: any = []

    if(page.props.auth.user.roles.some((role: any) => role.name === 'admin')) {
        _cards = [{
            label: 'S1 Admin',
            count: getCount('users', true),
            icon: 'pi pi-users'
        }]
    } else {
        _cards = [{
            label: 'Class Years',
            count: await getCount('classYears', false),
            icon: 'pi pi-flag'
        },
        {
            label: 'Cadets',
            count: await getCount('cadets', false),
            icon: 'pi pi-users'
        }]
    }

    cards.value = _cards
})

function getCount(module: string, isAdmin: boolean): number {
    let result:number = 0
    axios.get(route(`${module}.count`))
    .then((res) => {
        result = res.data.data
    })
    return result
}

</script>
