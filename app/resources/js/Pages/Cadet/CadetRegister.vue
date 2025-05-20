<template>
    <RegisterLayout>
        <div v-if="!completed" class="">
            <div class="mb-4 font-black text-2xl">Cadet Registration Form</div>
            <form @submit.prevent="submit" class="space-y-4">
                <div class="flex flex-col items-center gap-2 order-first lg:order-last">
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
                    <div class="flex items-center space-x-2">
                        <FloatLabel variant="in">
                            <InputText id="lastname" v-model="form.lastname" autocomplete="off" required
                                class="w-full" />
                            <label for="lastname">Last name</label>
                        </FloatLabel>
                        <FloatLabel variant="in">
                            <InputText id="firstname" v-model="form.firstname" autocomplete="off" required
                                class="w-full" />
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
                        <InputNumber v-model="form.age" inputId="in_label" class="w-full" required :useGrouping="false"/>
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
                        <InputText id="beneficiary" v-model="form.beneficiary" autocomplete="off" required
                            class="w-full" />
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
        </div>
        <div v-else class="space-y-2">
            <div class="text-center font-bold text-2xl">Welcome to ROTC</div>
            <div class="text-center mt-4">
                <p class="text-lg">Hang tight! 🚀 We're sending an email to confirm your enrollment. Get ready for an exciting ROTC journey!</p>
                <p class="text-sm text-gray-500 mt-2">This might take a few moments. Thank you for your patience!</p>
            </div>
        </div>
    </RegisterLayout>
</template>
<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import RegisterLayout from '@/Layouts/RegisterLayout.vue';
import { InputText, Select, FloatLabel, InputNumber, DatePicker, FileUpload, Button, Password, useToast } from 'primevue';
import { CadetTypes } from '@/Pages/Cadet/Types/CadetTypes'
import { router, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';

interface CadetWithRouteTypes extends CadetTypes {
    route?: string
}
const courses = ref<{value: string, label: string}[]>([
    { value: 'bsit', label: 'Bachelor of Science in Information Technology' },
    { value: 'bsba', label: 'Bachelor of Science in Business Administration' },
    { value: 'bspolsci', label: 'Bachelor of Science in Political Science' },
    { value: 'bshm', label: 'Bachelor of Science in Hospital Management' },
    { value: 'bsed', label: 'Bachelor of Science in Elementary Education' },
    { value: 'bsse', label: 'Bachelor of Science in Secondary Education' }
]);
const completed = ref<boolean>(false)
const cadet = ref<CadetTypes>({})
const page = usePage();
const toast = useToast()
const form = useForm<CadetWithRouteTypes>({
    id_number: undefined,
    class_year_id: page.props.class_year_id as number,
    subject: 'ms-',
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
    email: '',
    route: 'register',
    password: '',
    image: undefined,
})

function onFileSelect(event: any) {
    const file = event.files[0];
    const reader = new FileReader();

    reader.onload = async (e) => {
        form.image = e.target?.result;
    };

    reader.readAsDataURL(file);
}

async function submit() {
    form.name = `${form.lastname}, ${form.firstname}`

    axios.post(route('cadets.store'), form.data())
        .then((res) => {
            cadet.value = res.data
            toast.add({ severity: 'success', summary: 'Success', detail: `Successfully Registered Goodluck and have fun in ROTC`, life: 8000 });
            form.reset()
            completed.value = true
        })
        .catch(err => {
            if(err.response.status === 410) {
                router.visit(route('cadets.create'), {method: 'get'})
            }

            if (err.response.status === 422) {
                form.setError(err.response.data.errors)
            }
        })
}

</script>