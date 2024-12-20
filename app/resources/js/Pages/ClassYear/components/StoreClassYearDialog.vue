<template>
    <Dialog v-model:visible="visible" modal :header="`Add Class Year`" @hide="close">
        <form @submit.prevent="submit" class="space-y-4">
            <InputError class="mt-2" :message="form.errors.cl" />
            <div class="space-y-4">
                <div class="">
                    <FloatLabel variant="in">
                        <InputNumber id="class" v-model="form.class" autocomplete="off" required class="w-full" :useGrouping="false"/>
                        <label for="class">Class</label>
                    </FloatLabel>
                    <InputError class="mt-2" :message="form.errors.class" />
                </div>
                <div>
                    <FloatLabel variant="in">
                        <InputNumber id="year" v-model="form.year" autocomplete="off" required class="w-full" :useGrouping="false"/>
                        <label for="year">Year</label>
                    </FloatLabel>
                    <InputError class="mt-2" :message="form.errors.year" />
                </div>
            </div>
            <div>
                <Button type="submit" severity="success" label="submit" class="w-full" />
            </div>
        </form>
    </Dialog>
</template>
<script setup lang="ts">
import { Button } from 'primevue';
import { InputNumber, FloatLabel } from 'primevue';
import InputError from '../../../Components/InputError.vue'
import { Dialog } from 'primevue';
import { inject, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { ClassYearTypes } from '../Types/ClassYearTypes';
import { useToast } from 'primevue';

const toast = useToast()
const form = useForm<ClassYearTypes>({
    class: undefined,
    year: undefined,
    cl: ''
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

    form.post(route('classYears.store'), {
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