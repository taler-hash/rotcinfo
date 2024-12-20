<template>
    <Dialog v-model:visible="visible" modal :header="`Add S1 Admin`" @hide="close">
        <form @submit.prevent="submit" class="space-y-4">
            <div class="">
                <FloatLabel variant="in">
                    <InputText id="username" v-model="form.username" autocomplete="off" required class="w-full" />
                    <label for="username">Username</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.username" />
            </div>

            <div class="">
                <div class="flex items-center space-x-2">
                    <FloatLabel variant="in">
                        <InputText id="lastname" v-model="form.lastname" autocomplete="off" required class="w-full" />
                        <label for="lastname">Last name</label>
                    </FloatLabel>
                    <FloatLabel variant="in">
                        <InputText id="firstname" v-model="form.firstname" autocomplete="off" required class="w-full" />
                        <label for="firstname">First name</label>
                    </FloatLabel>
                </div>
                <InputError class="mt-2" :message="form.errors.name" />
            </div>
            <FloatLabel variant="in">
                <InputText id="password" v-model="form.password" autocomplete="off" class="w-full" type="password" />
                <label for="password">Password</label>
            </FloatLabel>
            <InputError class="mt-2" :message="form.errors.password" />
            <div class="pt-4">
                <Button type="submit" severity="success" label="submit" class="w-full" />
            </div>
        </form>
    </Dialog>
</template>
<script setup lang="ts">
import { Button } from 'primevue';
import { InputText, InputNumber, FileUpload, Select, FloatLabel } from 'primevue';
import InputError from '../../../Components/InputError.vue'
import { Dialog } from 'primevue';
import { inject, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { UserTypes } from '@/Pages/User/Types/UserTypes'
import { useToast } from 'primevue';

const toast = useToast()
const form = useForm<UserTypes>({
    firstname: '',
    lastname: '',
    name: '',
    username: '',
    password: '',
    position: 's1-admin'
})

const reloadTable = inject<any>('reloadTable')
const visible = ref<boolean>(false)

function open() {
    visible.value = true
}

function close() {
    visible.value = false
    form.reset()
    reloadTable()
}

async function submit() {
    form.name = `${form.lastname}, ${form.firstname}`

    form.post(route('users.store'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Added S1-Admin Successfully`, life: 3000 });
            close()
            form.reset()
        }
    })
}

defineExpose({
    open
})
</script>