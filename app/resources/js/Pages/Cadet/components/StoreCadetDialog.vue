<template>
    <Dialog v-model:visible="visible" modal :header="`Add Cadet`" @hide="close">
        <form @submit.prevent="submit" class="space-y-4">
            <div class="flex flex-col gap-2 order-first lg:order-last items-center">
                <img v-if="form.image" :src="form.image" alt="" class="shadow-md rounded-xl w-64" />
                <FileUpload mode="basic" @select="onFileSelect" customUpload auto severity="secondary" choose-label="Choose Image"
                    class="p-button-outlined" />
                <InputError :message="form.errors.image" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <InputNumber v-model="form.id_number" inputId="in_label" class="w-full" required :useGrouping="false"/>
                    <label for="in_label">Id Number</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.id_number" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <LazySelect module="classYears" label="cl" v-model="form.class_year_id" />
                    <label for="cl">Class Year</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.class_year_id" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <Select v-model="form.subject" :options="subjectOptions" class="w-full" required />
                    <label for="lastname">Subject</label>
                </FloatLabel>
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
            <div class="">
                <FloatLabel variant="in">
                    <Select :options="['male', 'female']" v-model="form.gender" required class="w-full" />
                    <label for="gender">Gender</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.gender" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <InputNumber v-model="form.age" inputId="in_label" class="w-full" required />
                    <label for="in_label">Age</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.age" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <DatePicker id="dob" v-model="form.dob" autocomplete="off" required class="w-full" />
                    <label for="dob">Date of Birth</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.dob" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <InputText id="address" v-model="form.address" autocomplete="off" required class="w-full" />
                    <label for="address">Address</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.address" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <Select :options="courses" v-model="form.course" optionLabel="label" optionValue="value" required class="w-full" />
                    <label for="course">Course</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.course" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <InputText id="religion" v-model="form.religion" autocomplete="off" required class="w-full" />
                    <label for="religion">Religion</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.religion" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <InputText id="b_type" v-model="form.b_type" autocomplete="off" required class="w-full" />
                    <label for="b_type">Blood Type</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.b_type" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <InputText id="height" v-model="form.height" autocomplete="off" required class="w-full" />
                    <label for="height">Height</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.height" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <InputText id="beneficiary" v-model="form.beneficiary" autocomplete="off" required class="w-full" />
                    <label for="beneficiary">Beneficiary</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.beneficiary" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <InputText id="email" v-model="form.email" autocomplete="off" required class="w-full" />
                    <label for="email">Email</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <div class="w-full">
                <FloatLabel variant="in" class="w-full">
                    <Password id="password" v-model="form.password" autocomplete="off" required :feedback="true" toggleMask :pt="{
                        InputText: 'grow',
                        root: {
                            class: 'w-full'
                        }
                        
                    }"/>
                    <label for="password">Password</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.password" />
            </div>
            <div class="pt-4">
                <Button type="submit" severity="success" label="submit" class="w-full" />
            </div>
        </form>
    </Dialog>
</template>
<script setup lang="ts">
import { Button } from 'primevue';
import LazySelect from '@/Components/Lazyselect/LazySelect.vue';
import { InputText, Select, FloatLabel, InputNumber, DatePicker, FileUpload, Password } from 'primevue';
import InputError from '../../../Components/InputError.vue'
import { Dialog } from 'primevue';
import { inject, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { CadetTypes } from '@/Pages/Cadet/Types/CadetTypes'
import { useToast } from 'primevue';
import axios from 'axios';

const toast = useToast()
const form = useForm<CadetTypes>({
    id_number: undefined,
    firstname: '',
    lastname: '',
    name: '',
    gender: 'male',
    age: 0,
    dob: undefined,
    address: '',
    course: '',
    religion: '',
    b_type: '',
    height: '',
    beneficiary: '',
    class_year_id: undefined,
    email: '',
    subject: '',
    image: undefined,
    status: 'registered',
    password: ''
})

const courses = ref<{value: string, label: string}[]>([
    { value: 'bsit', label: 'Bachelor of Science in Information Technology' },
    { value: 'bsba', label: 'Bachelor of Science in Business Administration' },
    { value: 'bspolsci', label: 'Bachelor of Science in Political Science' },
    { value: 'bshm', label: 'Bachelor of Science in Hospital Management' },
    { value: 'bsee', label: 'Bachelor of Science in Elementary Education' },
    { value: 'bsse', label: 'Bachelor of Science in Secondary Education' }
]);
const subjectOptions = ref<string[]>([
    'ms-',
    'ms-3',
    'ms-4',
])
const reloadTable = inject<any>('reloadTable')
const visible = ref<boolean>(false)

function open() {
    visible.value = true
}

function close() {
    visible.value = false
    form.reset()
    form.clearErrors()
    reloadTable()
}

async function submit() {
    form.name = `${form.lastname}, ${form.firstname}`

    form.post(route('cadets.store'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Added Cadet Successfully`, life: 3000 });
            close()
            form.reset()
        },

    })
}

async function clOptions() {
    const res = await axios.get('')
}

function onFileSelect(event: any) {
    const file = event.files[0];
    const reader = new FileReader();

    reader.onload = async (e) => {
        form.image = e.target?.result;
    };

    reader.readAsDataURL(file);
}

defineExpose({
    open
})
</script>