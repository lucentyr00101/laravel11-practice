<script setup lang="ts">

import {Column} from '@/Components/types';

const props = defineProps<{
    columnConfig: Column[]
    dataSource: any[];
}>()

</script>

<template>
    <table>
        <thead>
            <tr>
                <th v-for="column in props.columnConfig" :key="column.field">
                    {{ column.label }}
                </th>
            </tr>
        </thead>
        <tbody>
        <tr v-for="row in props.dataSource" :key="row.id">
            <td v-for="column in props.columnConfig" :key="column.field" class="text-center">
                {{ column.render ? column.render() : row[column.field] }}
            </td>
            <td>
                <slot name="actions" :row="dataSource.find(x => x.id === row.id)" />
            </td>
        </tr>
        </tbody>
    </table>
</template>
