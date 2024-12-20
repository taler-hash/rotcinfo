<template>
    <Dialog v-model:visible="visible" modal :header="`S1 Admin`" @hide="close">
        <form @submit.prevent="submit" class="space-y-4">
            <FloatLabel variant="in">
                <InputText id="username" v-model="form.username" autocomplete="off" disabled class="w-full" />
                <label for="username">Username</label>
            </FloatLabel>
            <div class="flex items-center space-x-2">
                <FloatLabel variant="in">
                    <InputText id="lastname" v-model="form.lastname" autocomplete="off" disabled class="w-full" />
                    <label for="lastname">Last name</label>
                </FloatLabel>
                <FloatLabel variant="in">
                    <InputText id="firstname" v-model="form.firstname" autocomplete="off" disabled class="w-full" />
                    <label for="firstname">First name</label>
                </FloatLabel>
            </div>
            <FloatLabel variant="in">
                <InputText id="username" v-model="form.username" autocomplete="off" disabled class="w-full" />
                <label for="username">Username</label>
            </FloatLabel>
            <InputError class="mt-2" :message="form.errors.username" />
        </form>
    </Dialog>
</template>
<script setup lang="ts">
import { Button } from 'primevue';
import { InputText, FloatLabel } from 'primevue';
import InputError from '../../../Components/InputError.vue'
import { Dialog } from 'primevue';
import { inject, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { UserTypes } from '@/Pages/User/Types/UserTypes';
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

function open(props: UserTypes) {
    form.defaults(props)
    form.reset()
    visible.value = true
}

function close() {
    visible.value = false
    form.reset()
    reloadTable()
}

async function submit() {
    form.put(route('users.update'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Updated S1-Admin Details Successfully`, life: 3000 });
            close()
            form.reset()
        }
    })
}


defineExpose({
    open
})
</script>