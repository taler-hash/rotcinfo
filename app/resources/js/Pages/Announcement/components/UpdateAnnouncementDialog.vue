<template>
    <Dialog v-model:visible="visible" modal :header="`Update Announcement`" @hide="close">
        <form @submit.prevent="submit" class="space-y-4">
            <div class="flex flex-col items-center space-y-4">
                <img v-if="form?.image" :src="form.image" class="shadow-md rounded-xl w-64" />
                <img v-else :src="form.media?.[0].original_url" alt="Image" class="shadow-md rounded-xl w-64" />
                <FileUpload mode="basic" @select="onFileSelect" customUpload auto severity="secondary"
                    choose-label="Choose Image" class="p-button-outlined" />
                <InputError :message="form.errors.image" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <InputText id="header" v-model="form.header" autocomplete="off" required class="w-full" />
                    <label for="header">Header</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.header" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <Textarea id="description" v-model="form.description" autocomplete="off" required class="w-full"
                        rows="5" cols="30" />
                    <label for="description">description</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.description" />
            </div>
            <div class="pt-4">
                <Button type="submit" severity="success" label="submit" class="w-full" />
            </div>
        </form>
    </Dialog>
</template>
<script setup lang="ts">
import { Button } from 'primevue';
import { InputText, Textarea, FileUpload, FloatLabel } from 'primevue';
import InputError from '../../../Components/InputError.vue'
import { Dialog } from 'primevue';
import { inject, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { AnnouncementTypes } from '@/Pages/Announcement/Types/AnnouncementTypes'
import { useToast } from 'primevue';

const toast = useToast()
const form = useForm<AnnouncementTypes>({
    header: '',
    description: '',
    image: null
})

const reloadTable = inject<any>('reloadTable')
const visible = ref<boolean>(false)

function open(props: AnnouncementTypes) {
    form.defaults(props)
    form.reset()
    visible.value = true
}


function close() {
    visible.value = false
    form.reset()
    reloadTable()
}

function onFileSelect(event: any) {
    const file = event.files[0];
    const reader = new FileReader();

    reader.onload = async (e) => {
        form.image = e.target?.result;
    };

    reader.readAsDataURL(file);
}


async function submit() {

    form.put(route('announcements.update'), {
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