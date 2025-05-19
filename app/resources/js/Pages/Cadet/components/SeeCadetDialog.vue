<template>
    <Dialog v-model:visible="visible" modal :header="`Cadet`" @hide="close">
        <form @submit.prevent="submit" class="space-y-4 relative">
            <div class="absolute w-full h-full z-50"></div>
            <div class="w-full flex justify-center">
                <img v-if="form.media?.[0].original_url" :src="form.media?.[0].original_url" alt="" class="shadow-md rounded-xl w-64" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <InputNumber v-model="form.id_number" inputId="in_label" class="w-full" required :useGrouping="false"/>
                    <label for="id_number">Id Number</label>
                </FloatLabel>
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <Select :options="['registered', 'enrolled']" v-model="form.status" required class="w-full"/>
                    <label for="status">Status</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.status" />
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
                    <Select v-model="form.subject" :options="subjectOptions" class="w-full" />
                    <label for="lastname">Subject</label>
                </FloatLabel>
            </div>
            <div class="">
                <div class="flex items-center space-x-2">
                    <div class="">
                        <FloatLabel variant="in">
                            <InputNumber id="sem_1_grade" v-model="form.sem_1_grade" autocomplete="off" readonly :useGrouping="false" :minFractionDigits="2" :maxFractionDigits="2" fluid
                                class="w-full" />
                            <label for="sem_1_grade">1st Sem Grade</label>
                        </FloatLabel>
                        <InputError class="mt-2" :message="form.errors.sem_1_grade" />
                    </div>
                    <div class="">
                        <FloatLabel variant="in">
                            <InputNumber id="sem_2_grade" v-model="form.sem_2_grade" autocomplete="off" readonly :useGrouping="false" :minFractionDigits="2" :maxFractionDigits="2" fluid
                                class="w-full" />
                            <label for="sem_2_grade">2nd Sem Grade</label>
                        </FloatLabel>
                        <InputError class="mt-2" :message="form.errors.sem_2_grade" />
                    </div>
                </div>
            </div>
            <div class="">
                <div class="flex items-center space-x-2">
                    <FloatLabel variant="in">
                        <InputText id="lastname" v-model="form.lastname" autocomplete="off" readonly class="w-full" />
                        <label for="lastname">Last name</label>
                    </FloatLabel>
                    <FloatLabel variant="in">
                        <InputText id="firstname" v-model="form.firstname" autocomplete="off" readonly class="w-full" />
                        <label for="firstname">First name</label>
                    </FloatLabel>
                </div>
                <InputError class="mt-2" :message="form.errors.name" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <Select :options="['male', 'female']" v-model="form.gender" class="w-full" />
                    <label for="gender">Gender</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.gender" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <InputNumber v-model="form.age" inputId="in_label" class="w-full" readonly/>
                    <label for="in_label">Age</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.age" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <DatePicker id="dob" v-model="form.dob" autocomplete="off" readonly class="w-full" />
                    <label for="dob">Date of Birth</label>
                </FloatLabel>
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <InputText id="address" v-model="form.address" autocomplete="off" readonly class="w-full" />
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
                    <InputText id="religion" v-model="form.religion" autocomplete="off" readonly class="w-full" />
                    <label for="religion">Religion</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.religion" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <InputText id="b_type" v-model="form.b_type" autocomplete="off" readonly class="w-full" />
                    <label for="b_type">Blood Type</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.b_type" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <InputText id="height" v-model="form.height" autocomplete="off" readonly class="w-full" />
                    <label for="height">Height</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.height" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <InputText id="beneficiary" v-model="form.beneficiary" autocomplete="off" readonly class="w-full" />
                    <label for="beneficiary">Beneficiary</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.beneficiary" />
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <InputText id="email" v-model="form.email" autocomplete="off" readonly class="w-full" />
                    <label for="email">Email</label>
                </FloatLabel>
                <InputError class="mt-2" :message="form.errors.email" />
            </div>
        </form>
    </Dialog>
</template>
<script setup lang="ts">
import LazySelect from '@/Components/Lazyselect/LazySelect.vue';
import { InputText, InputNumber, Select, FloatLabel, DatePicker } from 'primevue';
import InputError from '../../../Components/InputError.vue'
import { Dialog } from 'primevue';
import { inject, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { CadetTypes } from '@/Pages/Cadet/Types/CadetTypes';
import { useToast } from 'primevue';
import moment from 'moment';

const toast = useToast()
const form = useForm<CadetTypes>({})

const reloadTable = inject<any>('reloadTable')
const visible = ref<boolean>(false)
    const subjectOptions = ref<string[]>([
    'ms-',
    'ms-3',
    'ms-4',
])
const courses = ref<{value: string, label: string}[]>([
    { value: 'bsit', label: 'Bachelor of Science in Information Technology' },
    { value: 'bsba', label: 'Bachelor of Science in Business Administration' },
    { value: 'bspolsci', label: 'Bachelor of Science in Political Science' },
    { value: 'bshm', label: 'Bachelor of Science in Hospital Management' },
    { value: 'bsee', label: 'Bachelor of Science in Elementary Education' },
    { value: 'bsse', label: 'Bachelor of Science in Secondary Education' }
]);

function open(props: CadetTypes) {
    form.defaults(props)
    form.defaults({
        dob: moment(props.dob).toDate()
    })
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
            toast.add({ severity: 'success', summary: 'Success', detail: `Updated Cadet Details Successfully`, life: 3000 });
            close()
            form.reset()
        }
    })
}

defineExpose({
    open
})
</script>