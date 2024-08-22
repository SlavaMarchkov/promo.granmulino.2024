<template>
    <th
        v-if="sortable"
        scope="col"
        :class="[
            sortByColumn ? 'table-active' : '',
            isNumeric ? '' : 'text-start'
        ]"
        :style="{ width: width + '%' }"
        style="cursor: pointer;"
        @click="handleClick(column, isNumeric)"
    >
        <slot/>
        <template v-if="sortByColumn">
            <span v-if="sortByAsc === true">
                <i :class="[
                    'bi',
                    'ms-1',
                    isNumeric
                        ? 'bi-sort-numeric-up'
                        : 'bi-sort-alpha-up'
                ]"></i>
            </span>
            <span v-else-if="sortByAsc === false">
                <i :class="[
                    'bi',
                    'ms-1',
                    isNumeric
                        ? 'bi-sort-numeric-down-alt'
                        : 'bi-sort-alpha-down-alt'
                ]"></i>
            </span>
        </template>
        <template v-else>
            <i class="bi ms-1 bi-three-dots-vertical opacity-25"></i>
        </template>
    </th>
    <th
        v-else
        :style="{ width: width + '%' }"
        scope="col"
    >
        <slot/>
    </th>
</template>

<script setup>
const props = defineProps({
    sortable: {
        type: Boolean,
        default: false,
    },
    column: {
        type: String,
        default: 'id',
    },
    sortByColumn: {
        type: Boolean,
        default: false,
    },
    sortByAsc: {
        type: Boolean,
        default: true,
    },
    isNumeric: {
        type: Boolean,
        default: true,
    },
    width: {
        type: Number,
    },
});

const emit = defineEmits([
    'setSort',
]);

const handleClick = (column, is_num) => {
    emit('setSort', column, is_num);
};
</script>
