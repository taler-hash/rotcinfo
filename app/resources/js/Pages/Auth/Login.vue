<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <FloatLabel variant="in">
                    <InputText id="username" v-model="form.username" autocomplete="off" required class="w-full"/>
                    <label for="username">Username</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.username" />
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
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { InputText, Button, FloatLabel } from 'primevue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    username: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};
</script>
