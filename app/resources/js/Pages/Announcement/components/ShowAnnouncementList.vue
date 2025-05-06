<template>
    <Head title="Public Announcements" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Public Announcements
            </h2>
        </template>
        <div ref="wrapper" class="overflow-y-auto h-full">
            <div class="mx-auto max-w-5xl h-full px-8">
                <div class="p-4 py-10 shadow-sm sm:rounded-lg space-y-10">
                    <Card v-for="announcement in data?.data" class="w-full">
                        <template #header>
                            <div
                                class="w-full flex items-start justify-center h-96"
                            >
                                <img
                                    alt="user header"
                                    :src="announcement.media?.[0].original_url"
                                    class="h-full object-contain"
                                />
                            </div>
                        </template>
                        <template #title>
                            <p class="font-bold">{{ announcement.header }}</p>
                        </template>
                        <template #subtitle>{{
                            moment(announcement.created_at).format(
                                "dddd, Do MMM YYYY"
                            )
                        }}</template>
                        <template #content>
                            <p class="font-medium">
                                {{ announcement.description }}
                            </p>
                        </template>
                    </Card>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup lang="ts">
import moment from "moment";
import { useInfiniteScroll } from "@vueuse/core";
import { Card, Dock } from "primevue";
import { inject, onMounted, ref } from "vue";
import {
    AnnouncementPaginationTypes,
    FilterAnnouncementTypes,
} from "../Types/AnnouncementTypes";
import axios from "axios";
import { useToast } from "primevue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

const toast = useToast();
const items = ref<{ label: string; icon: string }[]>([
    {
        label: "Log out",
        icon: "bi bi-box-arrow-right",
    },
]);

onMounted(() => {
    getAnnouncements();
});

const wrapper = ref<HTMLElement | null>(null);
useInfiniteScroll(
    wrapper,
    () => {
        if (
            filters.value.page &&
            data.value?.last_page &&
            filters.value.page < data.value.last_page
        ) {
            addAnnouncements();
        }
    },
    { distance: 3 }
);

const filters = ref<FilterAnnouncementTypes>({
    page: 1,
    sortBy: "id",
    sortType: "desc",
    rows: 3,
    searchString: "",
});

const data = ref<AnnouncementPaginationTypes>();

async function getAnnouncements() {
    const res = await axios.get(route("announcements.index"), {
        params: filters.value,
    });

    if (res.status === 200) {
        data.value = res.data;
    }
}

async function addAnnouncements() {
    const res = await axios.get(route("announcements.public.index"), {
        params: filters.value,
    });

    if (data.value && res.status === 200) {
        filters.value.page += 1;
        data.value.data = data.value.data.concat(res.data.data);
    }
}
</script>
