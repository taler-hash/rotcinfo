<template>
    <DataTable :value="data?.data" removableSort paginator :totalRecords="data?.total" :rows="data?.per_page"
        class="border rounded-md" @sort="handleSort($event)" @page="handleChangePage($event)" lazy
        :rowsPerPageOptions="[5, 10, 20, 50]">
        <template #header>
            <div class="flex flex-wrap items-center justify-between">
                <div class="flex items-center space-x-2">
                    <SearchInput v-model="filters.searchString" @callback="reloadTable()" />
                </div>
                <div class="flex items-center-space-x-2">
                    <Button outlined icon="bi bi-plus" severity="success" @click="$refs.sud?.open()" />
                </div>
            </div>
        </template>
        <Column field="name" header="Name" sortable />
        <Column field="username" header="User name" sortable />
        <Column field="position" header="Position" sortable />
        <Column style="width: 10%">
            <template #header>
                <p class="text-center w-full">Actions</p>
            </template>
            <template #body="props">
                <div class="flex flex-nowrap justify-center">
                    <Button severity="info" icon="bi bi-eye" text @click="$refs.seud?.open(props.data)" />
                    <Button severity="warn" icon="bi bi-pencil" text @click="$refs.uud?.open(props.data)" />
                    <Button severity="danger" icon="bi bi-x" text @click="handleDeleteUser(props.data.id)" />
                </div>
            </template>
        </Column>
    </DataTable>
    <StoreUserDialog ref="sud" />
    <SeeUserDialog ref="seud" />
    <UpdateUserDialog ref="uud" />
</template>
<script setup lang="ts">
import { Column, Badge } from 'primevue';
import { DataTable, DataTablePageEvent, DataTableSortEvent, Avatar } from 'primevue';
import { Button } from 'primevue';
import SearchInput from '@/Components/SearchInput/SearchInput.vue';
import SeeUserDialog from './SeeUserDialog.vue';
import StoreUserDialog from './StoreUserDialog.vue';
import UpdateUserDialog from './UpdateUserDialog.vue';
import { onMounted, provide, ref } from 'vue';
import axios from 'axios';
import { useDebounceFn } from '@vueuse/core';
import { FilterUserTypes, UserPaginationTypes } from '@/Pages/User/Types/UserTypes';
import { useConfirm } from 'primevue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'primevue';

const toast = useToast()
const form = useForm<{ id?: number }>({})
const confirm = useConfirm()
const data = ref<UserPaginationTypes>()
const filters = ref<FilterUserTypes>({
    page: 1,
    sortBy: 'id',
    sortType: 'desc',
    rows: 10,
    searchString: '',
    roles: 's1-admin'
})

onMounted(() => {
    reloadTable()
})

async function reloadTable() {
    const res = await axios.get(route('users.index'), { params: filters.value })

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

function handleDeleteUser(id: number) {
    confirm.require({
        message: `Are you sure you want to delete this User`,
        header: 'Confirmation',
        icon: 'bi bi-info-circle',
        accept: () => {
            submitDeleteUser(id)
        }
    })
}

function submitDeleteUser(id: number) {
    form.defaults({ id: id })
    form.reset()
    form.delete(route('users.delete'), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: `Deleted User Successfully`, life: 3000 });
            reloadTable()
        }
    })
}

provide('reloadTable', reloadTable)
</script>