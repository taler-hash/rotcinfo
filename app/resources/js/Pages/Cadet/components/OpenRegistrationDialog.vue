<template>
    <Dialog header="Open Registration" modal v-model:visible="visible" @hide="close">
        <div class="">
            <div class="">
                <FloatLabel variant="in">
                    <LazySelect module="classYears" label="cl" v-model="form.class_year_id" />
                    <label for="cl">Class Year</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.class_year_id" />
            </div>
            <div class="pt-4">
                <Button severity="success" label="submit" class="w-full" :disabled="!form.isDirty" @click="submit" />
            </div>
        </div>
    </Dialog>
</template>
<script setup lang="ts">
import LazySelect from '@/Components/Lazyselect/LazySelect.vue';
import { useForm } from '@inertiajs/vue3';
import { Dialog, FloatLabel, Button, useToast } from 'primevue';
import { ref } from 'vue';
import InputError from '@/Components/InputError.vue';

interface OpenRegistrationTypes {
    class_year_id?: number
};

const toast = useToast()

const form = useForm<OpenRegistrationTypes>({
    class_year_id: undefined
})
const visible = ref<boolean>(false)

function open() {
    visible.value = true
}

function close() {
    visible.value = false
    form.reset()
    form.clearErrors()
}

function submit() {
    form.post(route('cadets.open'),{
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Open Cadet Registration Successfully valid for 1 day`, life: 6000 });
            close()
        }
    })
}

defineExpose({
    open
})
</script>