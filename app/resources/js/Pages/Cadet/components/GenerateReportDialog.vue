<template>
    <Dialog v-model:visible="visible" modal header="Generate Report" @hide="close">
        <form @submit.prevent="submit" class="space-y-4">
            <div class="">
                <FloatLabel variant="in">
                    <LazySelect label="cl" module="classYears" v-model="form.class_year_id"/>
                    <label for="class">Class Year</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.class_year_id" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <Select :options="[1, 2]" v-model="form.semester" required class="w-full" />
                    <label for="semester">Semester</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.semester" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <DatePicker id="date" v-model="form.date" autocomplete="off" required class="w-full" />
                    <label for="date">Date</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.date" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <InputText id="admin_nco" v-model="form.admin_nco" autocomplete="off" required class="w-full" />
                    <label for="admin_nco">Admin NCO Name</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.admin_nco " />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <InputText id="admin_nco_rank" v-model="form.admin_nco_rank" autocomplete="off" required class="w-full" />
                    <label for="admin_nco_rank">Admin NCO Rank</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.admin_nco_rank" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <InputText id="commandant" v-model="form.commandant" autocomplete="off" required class="w-full" />
                    <label for="commandant">Commandant Name</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.commandant" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <InputText id="commandant_rank" v-model="form.commandant_rank" autocomplete="off" required class="w-full" />
                    <label for="commandant_rank">Commandant Rank</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.commandant_rank" />
            </div>
            <div class="pt-4">
                <Button severity="success" label="submit" type="submit" class="w-full" :disabled="!form.isDirty"/>
            </div>
        </form>
    </Dialog>
</template>
<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import LazySelect from '@/Components/Lazyselect/LazySelect.vue';
import { ref } from 'vue';
import { Dialog, DatePicker, Select, FloatLabel, Button, InputText, useToast } from 'primevue';
import { useForm } from '@inertiajs/vue3';

interface FormTypes {
    class_year_id?: number,
    semester?: number,
    date?: Date,
    admin_nco?: string,
    admin_nco_rank?: string,
    commandant?: string,
    commandant_rank?: string,
}

const toast = useToast()
const visible = ref<boolean>(false)

const form = useForm<FormTypes>({
    class_year_id: undefined,
    semester: undefined,
    date: new Date(),
    admin_nco: '',
    admin_nco_rank: '',
    commandant: '',
    commandant_rank: '',
})

function open() {
    visible.value = true
}

function close() {
    visible.value = false
    form.reset()
    form.clearErrors()
}

function submit() {
    form.post(route('cadets.report.validate'), {
        onSuccess: () => {
            downloadReport()
            close()
            toast.add({ severity: 'success', summary: 'Success', detail: `Generated Report Successfully`, life: 5000 });
        }
    })
}

function downloadReport() {
    let reportLink = "/cadets/report?";
    const attributes = JSON.parse(JSON.stringify(form.data()))

    for(const attr in attributes) {
        reportLink += `${attr}=${attributes[attr]}&`
    }

    window.location.assign(reportLink)
}

defineExpose({
    open
})
</script>