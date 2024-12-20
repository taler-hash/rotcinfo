<template>
    <Dialog v-model:visible="visible" modal :header="`Announcement`" @hide="close">
        <div class="space-y-4">
            <div class="flex flex-col items-center space-y-4">
                <img v-if="form.media?.[0].original_url" :src="form.media?.[0].original_url" alt="Image" class="shadow-md rounded-xl w-64" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <InputText id="header" v-model="form.header" autocomplete="off" readonly class="w-full" />
                    <label for="header">Header</label>
                </FloatLabel>
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <Textarea id="description" v-model="form.description" autocomplete="off" readonly class="w-full"
                        rows="5" cols="30" />
                    <label for="description">description</label>
                </FloatLabel>
            </div>
        </div>
    </Dialog>
</template>
<script setup lang="ts">
import { InputText, Textarea, FloatLabel } from 'primevue';
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

defineExpose({
    open
})
</script>