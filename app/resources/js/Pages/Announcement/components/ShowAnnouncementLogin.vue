<template>
    <GuestLayout>
        <Head title="Announcement Log in" />
        <form @submit.prevent="submit">
            <div>
                <FloatLabel variant="in">
                    <InputText id="email" v-model="form.email" autocomplete="off" required class="w-full"/>
                    <label for="email">Email</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <div class="mt-4">
                <FloatLabel variant="in">
                    <InputText id="password" v-model="form.password" autocomplete="off" required class="w-full" type="password"/>
                    <label for="password">Password</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Button type="submit" :class="{ 'opacity-25': form.processing }" class="w-full" severity="success"
                    :disabled="form.processing">
                    Log in
                </Button>
            </div>
        </form>
    </GuestLayout>
</template>
<script setup lang="ts">
import GuestLayout from '@/Layouts/ShowAnnouncementLayout.vue';
import InputError from '@/Components/InputError.vue';
import { InputText, Button, FloatLabel } from 'primevue';
import { Head, useForm } from '@inertiajs/vue3';
import { useToast } from 'primevue';
import { inject } from 'vue';

const toast = useToast()
let setIsLoggedIn = inject<(state: boolean) => {}>('setIsLoggedIn')
const form = useForm({
    email: '',
    password: '',
});

const submit = () => {
    form.post(route('announcements.public.login'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Login Successfully`, life: 3000 });
            setIsLoggedIn && setIsLoggedIn(true)
        },
    });
};
</script>
