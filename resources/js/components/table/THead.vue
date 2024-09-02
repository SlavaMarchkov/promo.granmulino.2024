<template>
    <thead>
    <tr>
        <template
            v-for="{ column, label, sortable, is_num, width } in props.fields"
            :key="column"
        >
            <ThSort
                :column="column"
                :is-numeric="is_num"
                :sort-by-asc="arrayHandlers.sortBy.asc"
                :sort-by-column="arrayHandlers.sortBy.column === column"
                :sortable="sortable"
                :width="width"
                @setSort="arrayHandlers.setSort(column, is_num)"
            >{{ label }}
            </ThSort>
        </template>
    </tr>
    </thead>
</template>

<script setup>
import { useArrayHandlers } from '@/use/useArrayHandlers.js';
import ThSort from "@/components/table/ThSort.vue";

const arrayHandlers = useArrayHandlers();

const props = defineProps({
    fields: {
        type: Array,
        default: [],
        required: true,
    },
});
</script>
