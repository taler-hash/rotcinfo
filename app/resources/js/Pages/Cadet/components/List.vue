<template>
    <DataTable :value="data?.data" removableSort paginator :totalRecords="data?.total" :rows="data?.per_page"
        class="border rounded-md" @sort="handleSort($event)" @page="handleChangePage($event)" lazy
        :rowsPerPageOptions="[5, 10, 20, 50]">
        <template #header>
            <div class="flex flex-wrap items-center justify-between">
                <div class="flex items-center space-x-2">
                    <SearchInput v-model="filters.searchString" @callback="reloadTable" />
                    <LazySelect module="classYears" v-model="filters.class_year_id" label="cl" @callback="reloadTable" placeholder="Select Class Year" />
                </div>
                <div class="flex items-center space-x-2">
                    <Button outlined icon="pi pi-ban" severity="warn" @click="handleCloseRegistration()" />
                    <Button outlined icon="pi pi-link" severity="info" @click="$refs.ord?.open()" />
                    <Button outlined icon="pi pi-print" severity="success" @click="$refs.grd?.open()" />
                    <Button outlined icon="pi pi-plus" severity="success" @click="$refs.scd?.open()" />
                </div>
            </div>
        </template>
        <Column field="name" header="Name" sortable />
        <Column field="course" header="Course" sortable />
        <Column field="age" header="Age" sortable />
        <Column field="sem_1_grade" header="1st Sem" sortable />
        <Column field="sem_2_grade" header="2nd Sem" sortable />
        <Column header="Status" sortable>
            <template #body="props">
                <div class="">
                    <Badge :severity="statusSeverity(props.data.status)" :value="props.data.status" />
                </div>
            </template>
        </Column>
        <Column style="width: 10%">
            <template #header>
                <p class="text-center w-full">Actions</p>
            </template>
            <template #body="props">
                <div class="flex flex-nowrap justify-center">
                    <Button severity="info" icon="pi pi-eye" text @click="$refs.secd?.open(props.data)" />
                    <Button severity="warn" icon="pi pi-pencil" text @click="$refs.ucd?.open(props.data)" />
                    <Button severity="danger" icon="pi pi-times" text @click="handleDeleteCadet(props.data.id)" />
                </div>
            </template>
        </Column>
    </DataTable>
    <StoreCadetDialog ref="scd" />
    <SeeCadetDialog ref="secd" />
    <UpdateCadetDialog ref="ucd" />
    <GenerateReportDialog ref="grd" />
    <OpenRegistrationDialog ref="ord" />
</template>
<script setup lang="ts">
import { Column} from 'primevue';
import { DataTable, DataTablePageEvent, DataTableSortEvent, Badge } from 'primevue';
import { Button } from 'primevue';
import SearchInput from '@/Components/SearchInput/SearchInput.vue';
import SeeCadetDialog from '@/Pages/Cadet/components/SeeCadetDialog.vue';
import StoreCadetDialog from '@/Pages/Cadet/components/StoreCadetDialog.vue';
import UpdateCadetDialog from '@/Pages/Cadet/components/UpdateCadetDialog.vue';
import GenerateReportDialog from '@/Pages/Cadet/components/GenerateReportDialog.vue';
import OpenRegistrationDialog from './OpenRegistrationDialog.vue';
import { onMounted, provide, ref } from 'vue';
import axios from 'axios';
import { useDebounceFn } from '@vueuse/core';
import { FilterCadetTypes, CadetPaginationTypes } from '@/Pages/Cadet/Types/CadetTypes';
import { useConfirm } from 'primevue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'primevue';
import LazySelect from '@/Components/Lazyselect/LazySelect.vue';

const toast = useToast()
const form = useForm<{ id?: number }>({})
const confirm = useConfirm()
const data = ref<CadetPaginationTypes>()
const filters = ref<FilterCadetTypes>({
    page: 1,
    sortBy: 'id',
    sortType: 'desc',
    rows: 10,
    searchString: '',
    class_year_id: undefined
})

onMounted(() => {
    reloadTable()
})

async function reloadTable() {
    const res = await axios.get(route('cadets.index'), { params: filters.value })

    if (res.status === 200) {
        data.value = res.data
    }
}

function handleSort(e: DataTableSortEvent) {
    filters.value.sortBy = e.sortField as string ?? 'id'
    filters.value.sortType = e.sortOrder as number > 0 ? 'asc' : 'desc'

    reloadTable()
}

function handleChangePage(e: DataTablePageEvent) {
    filters.value.rows = e.rows
    filters.value.page = e.page + 1

    reloadTable()
}

const handleSearch = useDebounceFn(() => {
    reloadTable()
}, 1000)

function handleDeleteCadet(id: number) {
    confirm.require({
        message: `Are you sure you want to delete this Cadet`,
        header: 'Confirmation',
        icon: 'pi pi-info-circle',
        accept: () => {
            submitDeleteCadet(id)
        }
    })
}

function submitDeleteCadet(id: number) {
    form.defaults({ id: id })
    form.reset()
    form.delete(route('cadets.delete'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Deleted Cadet Successfully`, life: 3000 });
            reloadTable()
        }
    })
}

function handleOpenRegistration() {
    confirm.require({
        message: `Are you sure you want to open registration`,
        header: 'Confirmation',
        icon: 'pi pi-info-circle',
        accept: () => {
            submitOpenRegistration()
        }
    })
}

function submitOpenRegistration() {
    axios.post(route('cadets.open'))

    toast.add({ severity: 'success', summary: 'Success', detail: `Open Cadet Registration Successfully valid for 1 day`, life: 6000 });
}

function handleCloseRegistration() {
    confirm.require({
        message: `Are you sure you want to close registration`,
        header: 'Confirmation',
        icon: 'pi pi-info-circle',
        accept: () => {
            submitCloseRegistration()
        }
    })
}

function submitCloseRegistration() {
    axios.post(route('cadets.close'))

    toast.add({ severity: 'success', summary: 'Success', detail: `Close Cadet Registration Successfully`, life: 6000 });
}

function statusSeverity(status: string) {
    return status === 'active' ? 'success' : 'danger';
}

provide('reloadTable', reloadTable)
</script>