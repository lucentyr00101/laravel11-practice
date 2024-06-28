<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios'
import {
    onBeforeMount,
    reactive
} from 'vue';
import DataTable from '@/Components/DataTable.vue';
import {Column} from '@/Components/types';

const columnConfig: Column[] = [
    {
        field: 'id',
        label: 'ID'
    },
    {
        field: 'name',
        label: 'Name'
    },
    {
        field: 'description',
        label: 'Description'
    },
    {
        field: 'actions',
        label: 'Actions',
    }
]

interface Product {
    id: number;
    name: string;
    description: string;
    price: number;
}

const state: {
    tableData: Product[]
} = reactive({
    tableData: []
})

onBeforeMount(async () => {
    try {
        const data = await axios.get('/api/products')
        state.tableData = data?.data || []
    } catch (e) {
        console.error(e)
    }
})

const handleEdit = (id: number) => {
    console.log(`Update ${id}`)
}

const handleDelete = (id: number) => {
    console.log(`Delete ${id}`)
}


</script>

<template>
    <Head title="Products" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Products</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <DataTable
                            :columnConfig="columnConfig"
                            :dataSource="state.tableData">
                            <template v-slot:actions="{ row }"
                            >
                                <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                                    @click="handleEdit(row.id)"

                                >Edit</button>
                                <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" @click="handleDelete(row.id)">Delete</button>

                            </template>
                        </DataTable>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
