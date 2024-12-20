<template>
    <TrackLayout>
        <div v-if="!cadet" class="">
            <div class="pb-5">
                <p class="text-2xl font-bold">Cadet Identifier</p>
            </div>
            <div class="">
                <FloatLabel variant="in">
                    <InputText id="religion" v-model="filters.cadet_identifier" autocomplete="off" required
                        class="w-full" />
                    <label for="religion">Cadet Identifier</label>
                </FloatLabel>
            </div>
            <div class="pt-4">
                <Button severity="success" label="Submit" @click="submit" class="w-full"
                    :disabled="!filters?.cadet_identifier" />
            </div>
        </div>
        <div v-else class="h-[calc(100vh-20rem)] overflow-hidden">
            <div class="space-y-4 h-full overflow-y-scroll">
                <div class="pb-5">
                    <p class="text-2xl font-bold">Cadet Information</p>
                </div>
                <div class="">
                    <FloatLabel variant="in">
                        <InputText id="cadet_identifier" v-model="cadet.cadet_identifier" autocomplete="off" readonly
                            class="w-full" />
                        <label for="cadet_identifier">Identifier</label>
                    </FloatLabel>
                </div>
                <div class="">
                    <FloatLabel variant="in">
                        <Select :options="['active', 'inactive']" v-model="cadet.status" readonly class="w-full" />
                        <label for="status">Status</label>
                    </FloatLabel>
                </div>
                <div class="">
                    <FloatLabel variant="in">
                        <LazySelect module="classYears" label="cl" v-model="cadet.class_year_id" :disabled='true' />
                        <label for="cl">Class Year</label>
                    </FloatLabel>
                </div>
                <div class="">
                    <div class="flex items-center space-x-2">
                        <div class="">
                            <FloatLabel variant="in">
                                <InputNumber id="sem_1_grade" v-model="cadet.sem_1_grade" autocomplete="off" readonly
                                    :useGrouping="false" :minFractionDigits="2" :maxFractionDigits="2" fluid
                                    class="w-full" />
                                <label for="sem_1_grade">1st Sem Grade</label>
                            </FloatLabel>
                        </div>
                        <div class="">
                            <FloatLabel variant="in">
                                <InputNumber id="sem_2_grade" v-model="cadet.sem_2_grade" autocomplete="off" readonly
                                    :useGrouping="false" :minFractionDigits="2" :maxFractionDigits="2" fluid
                                    class="w-full" />
                                <label for="sem_2_grade">2nd Sem Grade</label>
                            </FloatLabel>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="flex items-center space-x-2">
                        <FloatLabel variant="in">
                            <InputText id="lastname" v-model="cadet.lastname" autocomplete="off" readonly
                                class="w-full" />
                            <label for="lastname">Last name</label>
                        </FloatLabel>
                        <FloatLabel variant="in">
                            <InputText id="firstname" v-model="cadet.firstname" autocomplete="off" readonly
                                class="w-full" />
                            <label for="firstname">First name</label>
                        </FloatLabel>
                    </div>
                </div>
                <div class="">
                    <FloatLabel variant="in">
                        <Select :options="['male', 'female']" v-model="cadet.gender" disabled class="w-full" />
                        <label for="gender">Gender</label>
                    </FloatLabel>
                </div>
                <div class="">
                    <FloatLabel variant="in">
                        <InputNumber v-model="cadet.age" inputId="in_label" class="w-full" readonly />
                        <label for="in_label">Age</label>
                    </FloatLabel>
                </div>
                <div class="">
                    <FloatLabel variant="in">
                        <DatePicker id="dob" v-model="cadet.dob" autocomplete="off" readonly class="w-full" />
                        <label for="dob">Date of Birth</label>
                    </FloatLabel>
                </div>
                <div class="">
                    <FloatLabel variant="in">
                        <InputText id="address" v-model="cadet.address" autocomplete="off" readonly class="w-full" />
                        <label for="address">Address</label>
                    </FloatLabel>
                </div>
                <div class="">
                    <FloatLabel variant="in">
                        <InputText id="course" v-model="cadet.course" autocomplete="off" readonly class="w-full" />
                        <label for="course">Course</label>
                    </FloatLabel>
                </div>
                <div class="">
                    <FloatLabel variant="in">
                        <InputText id="religion" v-model="cadet.religion" autocomplete="off" readonly class="w-full" />
                        <label for="religion">Religion</label>
                    </FloatLabel>
                </div>
                <div class="">
                    <FloatLabel variant="in">
                        <InputText id="b_type" v-model="cadet.b_type" autocomplete="off" readonly class="w-full" />
                        <label for="b_type">Blood Type</label>
                    </FloatLabel>
                </div>
                <div class="">
                    <FloatLabel variant="in">
                        <InputText id="height" v-model="cadet.height" autocomplete="off" readonly class="w-full" />
                        <label for="height">Height</label>
                    </FloatLabel>
                </div>
                <div class="">
                    <FloatLabel variant="in">
                        <InputText id="beneficiary" v-model="cadet.beneficiary" autocomplete="off" readonly
                            class="w-full" />
                        <label for="beneficiary">Beneficiary</label>
                    </FloatLabel>
                </div>
                <div class="">
                    <FloatLabel variant="in">
                        <InputText id="email" v-model="cadet.email" autocomplete="off" readonly class="w-full" />
                        <label for="email">Email</label>
                    </FloatLabel>
                </div>
            </div>
        </div>
    </TrackLayout>
</template>
<script setup lang="ts">
import TrackLayout from '@/Layouts/TrackLayout.vue';
import LazySelect from '@/Components/Lazyselect/LazySelect.vue';
import { FloatLabel, InputText, Button, useToast, InputNumber, Select, DatePicker } from 'primevue';
import { ref } from 'vue';
import { CadetTypes } from './Types/CadetTypes';
import axios from 'axios';

const toast = useToast()
const cadet = ref<CadetTypes>()
const filters = ref<{ cadet_identifier: string }>({
    cadet_identifier: ''
})
const visible = ref<boolean>(false)

function submit() {
    axios.get(route('cadets.show'), { params: filters.value })
        .then((res) => {
            console.log(res)
            cadet.value = res.data
        })
        .catch((err) => {
            console.log(err)

            if (err.response.status === 404) {
                toast.add({ severity: 'error', summary: 'Error', detail: `No Record Found`, life: 8000 });
            }
        })
}
</script>